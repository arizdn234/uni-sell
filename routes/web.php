<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\OrderItemController;
use App\Http\Controllers\ReviewController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CartItemController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\ShippingController;

// Home Route (can be customized)
Route::get('/', function () {
    return view('welcome');
});

// User Routes
Route::resource('users', UserController::class);

// Category Routes
Route::resource('categories', CategoryController::class);

// Product Routes
Route::resource('products', ProductController::class);

// Order Routes
Route::resource('orders', OrderController::class);

// OrderItem Routes
Route::resource('order-items', OrderItemController::class);

// Review Routes
Route::resource('reviews', ReviewController::class);

// Cart Routes
Route::resource('carts', CartController::class);

// CartItem Routes
Route::resource('cart-items', CartItemController::class);

// Payment Routes
Route::resource('payments', PaymentController::class);

// Shipping Routes
Route::resource('shippings', ShippingController::class);
