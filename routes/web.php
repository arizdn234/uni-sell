<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\AdminDashboardController;
use App\Http\Middleware\CheckAdmin;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\ReviewController;
use App\Http\Controllers\ShippingController;
use App\Http\Controllers\UserController;

Route::get('/', function () {
    return view('welcome');
});

Route::middleware(['auth', 'verified', CheckAdmin::class])->group(function () {
    Route::prefix('admin')->group(function () {

        Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('admin.dashboard');
        
        // Route::get('/products', [ProductController::class, 'index'])->name('admin.products.index');
        // Route::get('/products/create', [ProductController::class, 'create'])->name('admin.products.create');
        // Route::post('/products', [ProductController::class, 'store'])->name('admin.products.store');
        // Route::get('/products/{product}', [ProductController::class, 'show'])->name('admin.products.show');
        // Route::get('/products/{product}/edit', [ProductController::class, 'edit'])->name('admin.products.edit');
        // Route::put('/products/{product}', [ProductController::class, 'update'])->name('admin.products.update');
        // Route::delete('/products/{product}', [ProductController::class, 'destroy'])->name('admin.products.destroy');
        // Route::get('/products/export', [ProductController::class, 'export'])->name('products.export');
        
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
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
