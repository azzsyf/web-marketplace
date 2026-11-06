<?php

namespace App\Services;

use App\Models\Product as ProductModel;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\ValidationException;

class CartService
{
    private const SESSION_KEY = 'shop_cart';

    /** @return array<string, array{product_id:int,variant_id:int,quantity:int}> */
    public function items(): array
    {
        $items = Session::get(self::SESSION_KEY, []);

        return is_array($items) ? $items : [];
    }

    public function add(int $productId, int $variantId, int $quantity): void
    {
        if ($quantity < 1) {
            throw ValidationException::withMessages([
                'quantity' => 'Jumlah produk minimal 1.',
            ]);
        }

        $product = ProductModel::query()
            ->where('is_active', true)
            ->with('variants')
            ->find($productId);

        if (!$product) {
            throw ValidationException::withMessages([
                'quantity' => 'Produk sudah tidak tersedia.',
            ]);
        }

        $variant = $product->variants->firstWhere('id', $variantId);

        if (!$variant) {
            throw ValidationException::withMessages([
                'selectedVariant' => 'Varian produk tidak valid.',
            ]);
        }

        $key = $productId . '_' . $variantId;
        $cart = $this->items();
        $currentQuantity = (int) ($cart[$key]['quantity'] ?? 0);
        $newQuantity = $currentQuantity + $quantity;

        if ($newQuantity > (int) $variant->stock) {
            throw ValidationException::withMessages([
                'quantity' => "Stok tersedia hanya {$variant->stock} untuk varian ini.",
            ]);
        }

        $cart[$key] = [
            'product_id' => (int) $product->id,
            'variant_id' => (int) $variant->id,
            'quantity' => $newQuantity,
        ];

        Session::put(self::SESSION_KEY, $cart);
    }

    public function changeQuantity(string $key, int $quantity): void
    {
        $cart = $this->items();

        if (!isset($cart[$key]) || !$this->validKey($key)) {
            throw ValidationException::withMessages([
                'cart' => 'Item keranjang tidak ditemukan.',
            ]);
        }

        if ($quantity < 1) {
            throw ValidationException::withMessages([
                'cart' => 'Jumlah produk minimal 1.',
            ]);
        }

        [$productId, $variantId] = array_map('intval', explode('_', $key, 2));

        $variant = ProductModel::query()
            ->where('is_active', true)
            ->whereKey($productId)
            ->firstOrFail()
            ->variants()
            ->whereKey($variantId)
            ->first();

        if (!$variant) {
            unset($cart[$key]);
            Session::put(self::SESSION_KEY, $cart);

            throw ValidationException::withMessages([
                'cart' => 'Varian produk sudah tidak tersedia.',
            ]);
        }

        if ($quantity > (int) $variant->stock) {
            throw ValidationException::withMessages([
                'cart' => "Stok tersedia hanya {$variant->stock} untuk varian ini.",
            ]);
        }

        $cart[$key]['quantity'] = $quantity;
        Session::put(self::SESSION_KEY, $cart);
    }

    public function remove(string $key): void
    {
        $cart = $this->items();
        unset($cart[$key]);
        Session::put(self::SESSION_KEY, $cart);
    }

    public function clear(): void
    {
        Session::forget(self::SESSION_KEY);
    }

    public function count(): int
    {
        return collect($this->items())
            ->sum(fn ($item) => max(0, (int) ($item['quantity'] ?? 0)));
    }

    /**
     * Data tampilan selalu dibaca ulang dari database.
     * Harga dan stok tidak pernah dipercaya dari browser/session.
     *
     * @return array<int, array<string, mixed>>
     */
    public function detailedItems(): array
    {
        $cart = $this->items();
        $productIds = collect($cart)
            ->pluck('product_id')
            ->map(fn ($id) => (int) $id)
            ->filter(fn ($id) => $id > 0)
            ->unique()
            ->values();

        if ($productIds->isEmpty()) {
            return [];
        }

        $products = ProductModel::query()
            ->where('is_active', true)
            ->whereIn('id', $productIds)
            ->with('variants')
            ->get()
            ->keyBy('id');

        $result = [];
        $cleanCart = $cart;

        foreach ($cart as $key => $entry) {
            if (!$this->validKey((string) $key)) {
                unset($cleanCart[$key]);
                continue;
            }

            $productId = (int) ($entry['product_id'] ?? 0);
            $variantId = (int) ($entry['variant_id'] ?? 0);
            $quantity = max(1, (int) ($entry['quantity'] ?? 1));

            $product = $products->get($productId);
            $variant = $product?->variants->firstWhere('id', $variantId);

            if (!$product || !$variant || (int) $variant->stock < 1) {
                unset($cleanCart[$key]);
                continue;
            }

            // Bila stok turun sejak item masuk keranjang, sesuaikan quantity.
            $quantity = min($quantity, (int) $variant->stock);
            $cleanCart[$key]['quantity'] = $quantity;

            $unitPrice = (float) ($product->discount_price ?? $product->price);
            $imagePath = $this->primaryImagePath($product->image);

            $result[] = [
                'key' => (string) $key,
                'product_id' => (int) $product->id,
                'variant_id' => (int) $variant->id,
                'name' => (string) $product->name,
                'image_url' => $imagePath ? Storage::disk('public')->url($imagePath) : null,
                'size' => (string) $variant->size,
                'color' => (string) $variant->color,
                'quantity' => $quantity,
                'stock' => (int) $variant->stock,
                // Berat gram dapat disimpan pada kolom products.shipping_weight_grams.
                // Jika kolom tersebut belum ada/belum diisi, gunakan default dari config.
                'weight_grams' => max(1, (int) (
                    $product->getAttribute('shipping_weight_grams')
                    ?: config('services.rajaongkir.default_item_weight_grams', 500)
                )),
                'unit_price' => $unitPrice,
                'line_total' => $unitPrice * $quantity,
            ];
        }

        if ($cleanCart !== $cart) {
            Session::put(self::SESSION_KEY, $cleanCart);
        }

        return $result;
    }

    public function subtotal(): float
    {
        return collect($this->detailedItems())
            ->sum(fn ($item) => (float) $item['line_total']);
    }

    private function validKey(string $key): bool
    {
        return (bool) preg_match('/^\d+_\d+$/', $key);
    }

    private function primaryImagePath(mixed $value): ?string
    {
        if (is_string($value)) {
            $decoded = json_decode($value, true);

            if (json_last_error() === JSON_ERROR_NONE) {
                $value = $decoded;
            } else {
                return trim($value) !== '' ? $value : null;
            }
        }

        if (is_array($value)) {
            $path = collect($value)
                ->filter(fn ($item) => is_string($item) && trim($item) !== '')
                ->first();

            return $path ?: null;
        }

        return null;
    }
}
