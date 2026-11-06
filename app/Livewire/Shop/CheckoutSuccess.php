<?php

namespace App\Livewire\Shop;

use App\Models\Order;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Locked;
use Livewire\Component;

#[Layout('layouts.app')]
class CheckoutSuccess extends Component
{
    #[Locked]
    public int $orderId;

    public function mount(): void
    {
        $orderId = session('last_shop_order_id');

        abort_unless($orderId, 404);

        $this->orderId = (int) $orderId;
    }

    public function render()
    {
        $order = Order::query()
            ->with('items')
            ->findOrFail($this->orderId);

        return view('livewire.shop.checkout-success', [
            'order' => $order,
        ]);
    }
}
