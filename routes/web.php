<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\AdminDashboardController;
use App\Http\Controllers\ProductController;
use App\Http\Middleware\CheckAdmin;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

// Route::get('/admin-dashboard', [AdminDashboardController::class, 'index'])->name('admin.dashboard')->middleware(CheckAdmin::class);
// Route::get('/admin-dashboard/products', [ProductController::class, 'index'])->name('admin.product')->middleware(CheckAdmin::class);

// Grouping admin routes with middleware
Route::middleware(['auth', 'verified', CheckAdmin::class])->group(function () {
    Route::get('/admin-dashboard', [AdminDashboardController::class, 'index'])->name('admin.dashboard');
    
    // Additional admin routes
    Route::prefix('admin-dashboard')->group(function () {
        Route::get('/products', [ProductController::class, 'index'])->name('admin.product');
        // You can add more routes here for CRUD operations or other admin functionalities
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
