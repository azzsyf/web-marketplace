<?php

namespace App\Livewire;

use App\Models\Category as CategoryModel;
use App\Models\Product as ProductModel;
use Livewire\Component;
use Livewire\Attributes\Layout;

#[Layout('layouts.app')]
class Home extends Component
{
    public function render()
    {
        $categories = CategoryModel::query()
            ->whereIn('name', function ($query) {
                $query->select('category')
                    ->from('products')
                    ->where('is_active', true)
                    ->whereNotNull('category')
                    ->where('category', '!=', '');
            })
            ->orderBy('name')
            ->get();

        $products = ProductModel::query()
            ->where('is_active', true)
            ->withSum('variants as total_stock', 'stock')
            ->withCount('variants')
            ->latest()
            ->get();

        return view('livewire.home', [
            'categories' => $categories,
            'products' => $products,
        ]);
    }
}
