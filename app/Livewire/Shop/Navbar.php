<?php

namespace App\Livewire\Shop;

use App\Services\CartService;
use Livewire\Attributes\On;
use Livewire\Component;

class Navbar extends Component
{
    public int $cartCount = 0;

    public function mount(): void
    {
        $this->refreshCartCount();
    }

    #[On('cart-updated')]
    public function refreshCartCount(): void
    {
        $this->cartCount = app(CartService::class)->count();
    }

    public function render()
    {
        return view('livewire.shop.navbar');
    }
}
