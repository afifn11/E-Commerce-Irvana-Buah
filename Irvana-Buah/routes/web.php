<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ProductWebController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\CustomerOrderController;
use App\Http\Controllers\CustomerProfileController;

// ==========================================
// PUBLIC ROUTES - Frontend Customer
// ==========================================

// Home
Route::get('/', [HomeController::class, 'index'])->name('home');

// Shop / Produk
Route::get('/shop', [HomeController::class, 'products'])->name('products');
Route::get('/product/{slug}', [HomeController::class, 'productDetail'])->name('product.detail');
Route::get('/category/{slug}', [HomeController::class, 'productsByCategory'])->name('products.by.category');

// Halaman Statis
Route::get('/about', [HomeController::class, 'about'])->name('about');
Route::get('/contact', [HomeController::class, 'contact'])->name('contact');
Route::post('/contact', [HomeController::class, 'sendContactMessage'])->name('contact.send');

// Produk Diskon & Best Seller
Route::get('/discount-products', [HomeController::class, 'discountProducts'])->name('discount.products');
Route::get('/best-sellers', [HomeController::class, 'bestSellerProducts'])->name('best-sellers');

// AJAX / API Routes
Route::get('/search-products', [HomeController::class, 'searchProducts'])->name('search.products');
Route::get('/api/discount-stats', [HomeController::class, 'getDiscountStats'])->name('api.discount.stats');
Route::get('/api/trending-discounts', [HomeController::class, 'getTrendingDiscounts'])->name('api.trending.discounts');
Route::get('/api/best-sellers', [HomeController::class, 'getBestSellerProducts'])->name('api.best-sellers');

// ==========================================
// CART ROUTES - Semua user bisa akses halaman, tapi operasi butuh auth
// ==========================================
Route::prefix('cart')->name('cart.')->group(function () {
    Route::get('/', [CartController::class, 'index'])->name('index');
    Route::post('/add', [CartController::class, 'store'])->name('store');
    Route::put('/{id}', [CartController::class, 'update'])->name('update');
    Route::delete('/{id}', [CartController::class, 'destroy'])->name('destroy');
    Route::post('/clear', [CartController::class, 'clear'])->name('clear');
    Route::get('/checkout', [CartController::class, 'checkout'])->name('checkout');
    Route::get('/count', [CartController::class, 'getCount'])->name('count');
});

// Proses Checkout (butuh auth)
Route::post('/checkout/process', [CheckoutController::class, 'process'])->middleware('auth')->name('checkout.process');
Route::get('/checkout/success/{order}', [CheckoutController::class, 'success'])->middleware('auth')->name('checkout.success');

// ==========================================
// AUTHENTICATED ROUTES
// ==========================================
Route::get('/dashboard', [DashboardController::class, 'index'])
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::middleware(['auth'])->group(function () {
    // Profile
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Admin: Products CRUD
    Route::resource('/products', ProductWebController::class);
    
    // Admin: Categories CRUD
    Route::resource('categories', CategoryController::class);
    Route::post('categories/validate-image-url', [CategoryController::class, 'validateImageUrl'])
        ->name('categories.validate-image-url');

    // Admin: Users CRUD
    Route::resource('users', UserController::class);

    // Orders - admin semua, user lihat milik sendiri
    Route::resource('orders', OrderController::class);

    // Dashboard routes
    Route::get('/dashboard/refresh', [DashboardController::class, 'refreshStats'])->name('dashboard.refresh');
    Route::post('/dashboard/filter', [DashboardController::class, 'getDataByDateRange'])->name('dashboard.filter');
});

// ==========================================
// CUSTOMER ROUTES - Halaman khusus user biasa (bukan admin)
// ==========================================
Route::middleware(['auth'])->group(function () {
    // Pesanan customer
    Route::get('/my-orders', [CustomerOrderController::class, 'index'])->name('customer.orders');
    Route::get('/my-orders/{id}', [CustomerOrderController::class, 'show'])->name('customer.orders.show');

    // Profil customer
    Route::get('/my-profile', [CustomerProfileController::class, 'edit'])->name('customer.profile');
    Route::patch('/my-profile', [CustomerProfileController::class, 'update'])->name('customer.profile.update');
    Route::patch('/my-profile/password', [CustomerProfileController::class, 'updatePassword'])->name('customer.profile.password');
});

// Auth routes (login, register, dll)
require __DIR__.'/auth.php';
