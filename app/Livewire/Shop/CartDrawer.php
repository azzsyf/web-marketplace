<?php

namespace App\Livewire\Shop;

use App\Services\CartService;
use Illuminate\Validation\ValidationException;
use Livewire\Attributes\On;
use Livewire\Component;

class CartDrawer extends Component
{
    public bool $isOpen = false;
    public array $cartItems = [];
    public int $cartCount = 0;
    public float $subtotal = 0;
    public ?string $cartMessage = null;

    public function mount(): void
    {
        $this->refreshCartData();
    }

    #[On('open-cart')]
    public function openCart(): void
    {
        $this->refreshCartData();
        $this->isOpen = true;
    }

    #[On('cart-updated')]
    public function onCartUpdated(): void
    {
        $this->refreshCartData();
    }

    public function closeCart(): void
    {
        $this->isOpen = false;
        $this->resetValidation();
    }

    public function increase(string $key): void
    {
        $item = collect(app(CartService::class)->items())
            ->get($key);

        if (!$item) {
            return;
        }

        $this->changeQuantity($key, (int) ($item['quantity'] ?? 0) + 1);
    }

    public function decrease(string $key): void
    {
        $item = collect(app(CartService::class)->items())
            ->get($key);

        if (!$item) {
            return;
        }

        $quantity = (int) ($item['quantity'] ?? 0);

        if ($quantity > 1) {
            $this->changeQuantity($key, $quantity - 1);
        }
    }

    public function changeQuantity(string $key, int $quantity): void
    {
        try {
            app(CartService::class)->changeQuantity($key, $quantity);
            $this->cartMessage = null;
            $this->refreshCartData();
            $this->dispatch('cart-updated');
        } catch (ValidationException $exception) {
            $this->cartMessage = collect($exception->errors())->flatten()->first();
            $this->refreshCartData();
        }
    }

    public function remove(string $key): void
    {
        app(CartService::class)->remove($key);
        $this->cartMessage = null;
        $this->refreshCartData();
        $this->dispatch('cart-updated');
    }

    public function clearCart(): void
    {
        app(CartService::class)->clear();
        $this->cartMessage = null;
        $this->refreshCartData();
        $this->dispatch('cart-updated');
    }

    private function refreshCartData(): void
    {
        $cart = app(CartService::class);

        $this->cartItems = $cart->detailedItems();
        $this->cartCount = $cart->count();
        $this->subtotal = (float) collect($this->cartItems)
            ->sum(fn($item) => (float) $item['line_total']);
    }

    public function render()
    {
        return view('livewire.shop.cart-drawer');
    }
}
