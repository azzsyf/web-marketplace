<?php

namespace App\Livewire\Shop\Product;

use App\Models\Product as ProductModel;
use App\Services\CartService;
use Illuminate\Contracts\Encryption\DecryptException;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Validation\ValidationException;
use Livewire\Component;
use Livewire\Attributes\Layout;

#[Layout('layouts.app')]
class ProductDetail extends Component
{
    public ProductModel $product;

    public array $images = [];

    public ?int $selectedVariant = null;
    public int $quantity = 1;
    public int $activeImage = 0;

    public function mount(string $id): void
    {
        try {
            // Decode URL-safe encrypted ID.
            $encryptedId = strtr($id, '-_', '+/');
            $encryptedId .= str_repeat('=', (4 - strlen($encryptedId) % 4) % 4);

            $decryptedId = Crypt::decryptString($encryptedId);

            if (!ctype_digit($decryptedId)) {
                abort(404);
            }
        } catch (DecryptException $e) {
            abort(404);
        }

        $this->product = ProductModel::query()
            ->where('is_active', true)
            ->with('variants')
            ->findOrFail((int) $decryptedId);

        $this->images = $this->normalizeImages($this->product->image);
    }

    public function selectImage(int $index): void
    {
        if (isset($this->images[$index])) {
            $this->activeImage = $index;
        }
    }

    public function selectVariant(int $variantId): void
    {
        $variant = $this->product->variants->firstWhere('id', $variantId);

        if (!$variant || $variant->stock < 1) {
            return;
        }

        $this->selectedVariant = $variantId;
        $this->quantity = 1;
        $this->resetValidation();
    }

    public function increaseQuantity(): void
    {
        $variant = $this->product->variants->firstWhere('id', $this->selectedVariant);

        if ($variant && $this->quantity < $variant->stock) {
            $this->quantity++;
        }
    }

    public function decreaseQuantity(): void
    {
        if ($this->quantity > 1) {
            $this->quantity--;
        }
    }

    public function addToCart(): void
    {
        $this->validate([
            'selectedVariant' => ['required', 'integer'],
            'quantity' => ['required', 'integer', 'min:1'],
        ], [
            'selectedVariant.required' => 'Silakan pilih ukuran dan warna terlebih dahulu.',
        ]);

        try {
            app(CartService::class)->add(
                productId: $this->product->id,
                variantId: $this->selectedVariant,
                quantity: $this->quantity
            );

            // Update badge Navbar dan isi Cart Drawer.
            $this->dispatch('cart-updated');

            // Beri tanda berhasil pada browser bila ingin menampilkan toast.
            $this->dispatch('cart-item-added', message: 'Produk berhasil ditambahkan ke keranjang.');

            $this->resetValidation();
        } catch (ValidationException $exception) {
            foreach ($exception->errors() as $field => $messages) {
                $this->addError($field, $messages[0]);
            }
        }
    }

    private function normalizeImages(mixed $value): array
    {
        if (is_string($value)) {
            $value = json_decode($value, true);
        }

        if ($value instanceof \Illuminate\Support\Collection) {
            $value = $value->all();
        }

        if (!is_array($value)) {
            return [];
        }

        return array_values(array_filter(
            $value,
            fn($path) => is_string($path) && $path !== ''
        ));
    }

    public function render()
    {
        return view('livewire.shop.product.product-detail');
    }
}
