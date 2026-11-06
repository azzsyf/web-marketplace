<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Livewire\Admin\Category;
use App\Livewire\Admin\Dashboard;
use App\Livewire\Admin\Order;
use App\Livewire\Admin\Product;
use App\Livewire\Home;
use App\Livewire\Shop\Checkout;
use App\Livewire\Shop\CheckoutSuccess;
use App\Livewire\Shop\Product\ProductDetail;
use Illuminate\Support\Facades\Route;

// Auth Routes
Route::middleware('guest')->group(function () {
    Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [LoginController::class, 'login']);
    Route::get('/register', [RegisterController::class, 'showRegistrationForm'])->name('register');
    Route::post('/register', [RegisterController::class, 'register']);
});

Route::post('/logout', [LoginController::class, 'logout'])->name('logout')->middleware('auth');

// Public Routes
Route::get('/', Home::class)->name('home');

Route::get('/produk-detail/{id}', ProductDetail::class)
    ->name('product.detail');

Route::get('/checkout', Checkout::class)
    ->name('checkout.index');

Route::get('/checkout/success', CheckoutSuccess::class)
    ->name('checkout.success');

// Admin Routes (Protected)
Route::middleware(['auth', 'admin'])->prefix('admin')->group(function () {
    Route::get('/', Dashboard::class)->name('admin.dashboard');
    Route::get('/users', \App\Livewire\Admin\Users::class)->name('admin.users');
    Route::get('/products', Product::class)->name('admin.products');
    Route::get('/categories', Category::class)->name('admin.categories');
    Route::get('/orders', Order::class)->name('admin.orders');
    Route::get('/settings', \App\Livewire\Admin\Settings::class)->name('admin.settings');
});

