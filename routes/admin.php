<?php

use App\Http\Controllers\AdminDashboardController;
use App\Http\Controllers\ProductController;
use App\Http\Middleware\CheckAdmin;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth', 'verified', CheckAdmin::class])->group(function () {
    Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('admin.dashboard');
    // Add more admin-specific routes here
    // For example, routes for CRUD operations on products:
    Route::resource('products', ProductController::class);
});
