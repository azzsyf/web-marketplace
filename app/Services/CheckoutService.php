<?php

namespace App\Services;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product as ProductModel;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;

class CheckoutService
{
    public function __construct(private readonly CartService $cart) {}

    /**
     * Buat pesanan berdasarkan isi Session. Harga dan stok selalu dibaca ulang
     * dari database, dan stok dikunci selama proses checkout.
     */

    public function place(array $customerData): Order
    {
        $cartItems = $this->cart->items();

        if ($cartItems === []) {
            throw ValidationException::withMessages([
                'cart' => 'Keranjang masih kosong. Tambahkan produk sebelum checkout.',
            ]);
        }

        // Lock berdasarkan bulan agar nomor pesanan tidak bentrok.
        $yearMonth = now()->format('ym');
        $lockName = 'bakoel_order_' . $yearMonth;

        $lock = DB::selectOne(
            'SELECT GET_LOCK(?, 15) AS acquired',
            [$lockName]
        );

        if (!$lock || (int) $lock->acquired !== 1) {
            throw ValidationException::withMessages([
                'cart' => 'Sistem sedang memproses pesanan lain. Silakan coba kembali.',
            ]);
        }

        try {
            return DB::transaction(function () use ($cartItems, $customerData) {

                // Urutan konsisten mengurangi risiko deadlock.
                ksort($cartItems);

                $lines = [];
                $subtotal = 0.0;

                foreach ($cartItems as $key => $entry) {
                    if (!preg_match('/^(\d+)_(\d+)$/', (string) $key, $matches)) {
                        throw ValidationException::withMessages([
                            'cart' => 'Terdapat item keranjang yang tidak valid. Silakan perbarui keranjang.',
                        ]);
                    }

                    $productId = (int) ($entry['product_id'] ?? $matches[1]);
                    $variantId = (int) ($entry['variant_id'] ?? $matches[2]);
                    $quantity = (int) ($entry['quantity'] ?? 0);

                    if (
                        $productId !== (int) $matches[1] ||
                        $variantId !== (int) $matches[2] ||
                        $quantity < 1
                    ) {
                        throw ValidationException::withMessages([
                            'cart' => 'Data item keranjang tidak valid. Silakan muat ulang keranjang.',
                        ]);
                    }

                    $product = ProductModel::query()
                        ->where('is_active', true)
                        ->whereKey($productId)
                        ->lockForUpdate()
                        ->first();

                    if (!$product) {
                        throw ValidationException::withMessages([
                            'cart' => 'Salah satu produk sudah tidak tersedia. Periksa kembali keranjang.',
                        ]);
                    }

                    $variant = $product->variants()
                        ->whereKey($variantId)
                        ->lockForUpdate()
                        ->first();

                    if (!$variant) {
                        throw ValidationException::withMessages([
                            'cart' => "Varian {$product->name} sudah tidak tersedia.",
                        ]);
                    }

                    if ((int) $variant->stock < $quantity) {
                        throw ValidationException::withMessages([
                            'cart' => "Stok {$product->name} ukuran {$variant->size} / {$variant->color} tersisa {$variant->stock}. Silakan sesuaikan jumlahnya.",
                        ]);
                    }

                    $unitPrice = (float) ($product->discount_price ?? $product->price);
                    $lineTotal = round($unitPrice * $quantity, 2);

                    $lines[] = [
                        'product' => $product,
                        'variant' => $variant,
                        'quantity' => $quantity,
                        'unit_price' => $unitPrice,
                        'line_total' => $lineTotal,
                        'product_image' => $this->primaryImagePath($product->image),
                    ];

                    $subtotal += $lineTotal;
                }

                if ($lines === []) {
                    throw ValidationException::withMessages([
                        'cart' => 'Tidak ada produk valid untuk diproses.',
                    ]);
                }

                // Perhitungan ongkir dan total.
                $shippingCost = max(
                    0,
                    (float) ($customerData['shipping_cost'] ?? 0)
                );

                $discountAmount = 0.0;

                $grandTotal = round(
                    $subtotal + $shippingCost - $discountAmount,
                    2
                );

                // Buat pesanan.
                $order = Order::create([
                    'order_number' => $this->generateOrderNumber(),
                    'user_id' => Auth::id(),
                    'customer_name' => $customerData['customer_name'],
                    'customer_phone' => $customerData['customer_phone'],
                    'customer_email' => $customerData['customer_email'] ?: null,
                    'shipping_province' => $customerData['shipping_province'],
                    'shipping_city' => $customerData['shipping_city'],
                    'shipping_postal_code' => $customerData['shipping_postal_code'] ?: null,
                    'shipping_address' => $customerData['shipping_address'],
                    'shipping_destination_id' => $customerData['shipping_destination_id'] ?? null,
                    'shipping_destination_label' => $customerData['shipping_destination_label'] ?? null,
                    'shipping_courier' => $customerData['shipping_courier'],
                    'shipping_courier_name' => $customerData['shipping_courier_name'] ?? null,
                    'shipping_service' => $customerData['shipping_service'] ?? null,
                    'shipping_etd' => $customerData['shipping_etd'] ?? null,
                    'subtotal' => $subtotal,
                    'shipping_cost' => $shippingCost,
                    'discount_amount' => $discountAmount,
                    'grand_total' => $grandTotal,
                    'payment_method' => $customerData['payment_method'],
                    'payment_status' => 'unpaid',
                    'status' => 'pending',
                    'notes' => $customerData['notes'] ?: null,
                    'placed_at' => now(),
                ]);

                // Simpan detail pesanan dan kurangi stok.
                foreach ($lines as $line) {
                    $product = $line['product'];
                    $variant = $line['variant'];
                    $quantity = $line['quantity'];

                    OrderItem::create([
                        'order_id' => $order->id,
                        'product_id' => $product->id,
                        'variant_id' => $variant->id,
                        'product_name' => $product->name,
                        'product_sku' => $variant->sku ?: $product->sku,
                        'product_image' => $line['product_image'],
                        'variant_size' => $variant->size,
                        'variant_color' => $variant->color,
                        'unit_price' => $line['unit_price'],
                        'quantity' => $quantity,
                        'line_total' => $line['line_total'],
                    ]);

                    $variant->decrement('stock', $quantity);
                }

                return $order->load('items');
            }, 3);
        } finally {
            // Dilepas setelah transaksi commit atau rollback.
            DB::selectOne(
                'SELECT RELEASE_LOCK(?)',
                [$lockName]
            );
        }
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
            foreach ($value as $path) {
                if (is_string($path) && trim($path) !== '') {
                    return $path;
                }
            }
        }

        return null;
    }

    private function generateOrderNumber(): string
    {
        $yearMonth = now()->format('ym');
        $prefix = 'BJ-' . $yearMonth . '-';

        $lastOrder = Order::query()
            ->where('order_number', 'like', $prefix . '%')
            ->orderByRaw(
                'CAST(SUBSTRING_INDEX(order_number, "-", -1) AS UNSIGNED) DESC'
            )
            ->first();

        $lastNumber = $lastOrder
            ? (int) substr($lastOrder->order_number, -3)
            : 0;

        $nextNumber = $lastNumber + 1;

        if ($nextNumber > 999) {
            throw ValidationException::withMessages([
                'cart' => 'Nomor pesanan bulan ini sudah mencapai batas 999.',
            ]);
        }

        return $prefix . str_pad(
            (string) $nextNumber,
            3,
            '0',
            STR_PAD_LEFT
        );
    }
}
