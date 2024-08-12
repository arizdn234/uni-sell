<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\AdminDashboardController;
use App\Http\Middleware\CheckAdmin;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CartItemController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\ReviewController;
use App\Http\Controllers\ShippingController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ClientController;

Route::get('/', [ClientController::class, 'dashboard'])->name('dashboard');

Route::middleware(['auth', 'verified', CheckAdmin::class])->group(function () {
    Route::prefix('admin')->group(function () {

        Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('admin.dashboard');
        
        Route::resource('products', ProductController::class);
        Route::resource('categories', CategoryController::class);
        Route::resource('orders', OrderController::class);
        Route::resource('carts', CartController::class);
        Route::resource('payments', PaymentController::class);
        Route::resource('reviews', ReviewController::class);
        Route::resource('shippings', ShippingController::class);
        Route::resource('users', UserController::class);

    });
});

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/dashboard', [ClientController::class, 'dashboard'])->name('user.dashboard');
    
    Route::get('/cart', [ClientController::class, 'cart'])->name('user.cart');
    Route::post('/cart/add', [CartController::class, 'addToCart'])->name('cart.add');
    Route::post('/cart/update/{itemId}', [CartItemController::class, 'update'])->name('cart.update');
    Route::delete('/cart/remove/{itemId}', [CartItemController::class, 'destroy'])->name('cart.remove');
    
    Route::get('/promo', [ClientController::class, 'promo'])->name('promo.page');
    Route::get('/new', [ClientController::class, 'newArrivals'])->name('new.arrivals');

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
