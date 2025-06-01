<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ProductWebController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\UserController;

Route::get('/', function () {
    return view('welcome');
});

// Hanya user yang sudah login & terverifikasi bisa akses dashboard
Route::get('/dashboard', [DashboardController::class, 'index'])
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

// Group routes yang membutuhkan autentikasi
Route::middleware(['auth'])->group(function () {
    // Halaman profil
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // produk routes (CRUD)
    Route::resource('/products', ProductWebController::class);
    // kategori routes (CRUD)
    Route::resource('categories', CategoryController::class);
    // Route tambahan untuk validasi URL gambar
    Route::post('categories/validate-image-url', [CategoryController::class, 'validateImageUrl'])
        ->name('categories.validate-image-url');
    // User Management Routes
    Route::middleware(['auth'])->group(function () {
        Route::resource('users', UserController::class);
    });
    // kategori routes (CRUD)
    Route::resource('users', UserController::class);
});

// Route bawaan Breeze (login, register, dll)
require __DIR__.'/auth.php';
