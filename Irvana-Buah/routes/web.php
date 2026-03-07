<?php

use App\Http\Controllers\Admin;
use App\Http\Controllers\Customer;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

// ====================================================
// PUBLIC ROUTES — Storefront
// ====================================================

Route::get('/', [HomeController::class, 'index'])->name('home');
Route::post('/payment/notification', [Customer\PaymentController::class, 'notification'])->name('payment.notification');

// Shop
Route::get('/shop',              [HomeController::class, 'products'])->name('products');
Route::get('/product/{slug}',    [HomeController::class, 'productDetail'])->name('product.detail');
Route::get('/category/{slug}',   [HomeController::class, 'productsByCategory'])->name('products.by.category');

// Static pages
Route::get('/about',   [HomeController::class, 'about'])->name('about');
Route::get('/contact', [HomeController::class, 'contact'])->name('contact');
Route::post('/contact', [HomeController::class, 'sendContactMessage'])->name('contact.send');

// Promotions
Route::get('/discount-products', [HomeController::class, 'discountProducts'])->name('discount.products');
Route::get('/best-sellers',      [HomeController::class, 'bestSellerProducts'])->name('best-sellers');

// AJAX / JSON endpoints
Route::get('/search-products',          [HomeController::class, 'searchProducts'])->name('search.products');
Route::get('/api/discount-stats',        [HomeController::class, 'getDiscountStatsJson'])->name('api.discount.stats');
Route::get('/api/trending-discounts',    [HomeController::class, 'getTrendingDiscounts'])->name('api.trending.discounts');
Route::get('/api/best-sellers',          [HomeController::class, 'getBestSellerProductsJson'])->name('api.best-sellers');
Route::get('/api/products-by-category',  [HomeController::class, 'getProductsByCategoryJson'])->name('api.products.by.category');

// ====================================================
// CART ROUTES
// ====================================================

Route::prefix('cart')->name('cart.')->group(function () {
    Route::get('/',            [Customer\CartController::class, 'index'])->name('index');
    Route::post('/add',        [Customer\CartController::class, 'store'])->name('store');
    Route::put('/{id}',        [Customer\CartController::class, 'update'])->name('update');
    Route::delete('/{id}',     [Customer\CartController::class, 'destroy'])->name('destroy');
    Route::post('/clear',      [Customer\CartController::class, 'clear'])->name('clear');
    Route::get('/checkout',    [Customer\CartController::class, 'checkout'])->name('checkout');
    Route::get('/count',       [Customer\CartController::class, 'getCount'])->name('count');
});

// ====================================================
// CHECKOUT (requires auth)
// ====================================================

Route::middleware('auth')->group(function () {
    Route::post('/checkout/process',        [Customer\CheckoutController::class, 'process'])->name('checkout.process');
    Route::get('/checkout/success/{order}', [Customer\CheckoutController::class, 'success'])->name('checkout.success');
});

// ====================================================
// AUTHENTICATED — Dashboard (admin)
// ====================================================

Route::get('/dashboard', [Admin\DashboardController::class, 'index'])
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    // Dashboard
    Route::get('/dashboard/refresh', [Admin\DashboardController::class, 'refreshStats'])->name('dashboard.refresh');
    Route::post('/dashboard/filter', [Admin\DashboardController::class, 'getDataByDateRange'])->name('dashboard.filter');

    // Resources
    Route::resource('products',  Admin\ProductController::class);
    Route::resource('categories', Admin\CategoryController::class);
    Route::resource('users',     Admin\UserController::class);
    Route::resource('orders',    Admin\OrderController::class)->except(['create', 'store']);
    Route::resource('coupons',   Admin\CouponController::class);
    Route::patch('coupons/{coupon}/toggle', [Admin\CouponController::class, 'toggle'])->name('coupons.toggle');
    Route::get('reviews',                   [Admin\ReviewController::class, 'index'])->name('reviews.index');
    Route::post('reviews/{review}/reply',   [Admin\ReviewController::class, 'reply'])->name('reviews.reply');
    Route::patch('reviews/{review}/toggle', [Admin\ReviewController::class, 'toggle'])->name('reviews.toggle');
    Route::delete('reviews/{review}',       [Admin\ReviewController::class, 'destroy'])->name('reviews.destroy');

    // Category image validation
    Route::post('categories/validate-image-url', [Admin\CategoryController::class, 'validateImageUrl'])
        ->name('categories.validate-image-url');

    // Order status AJAX
    Route::patch('orders/{order}/status',         [Admin\OrderController::class, 'updateStatus'])->name('orders.update-status');
    Route::patch('orders/{order}/payment-status', [Admin\OrderController::class, 'updatePaymentStatus'])->name('orders.update-payment-status');
});

// ====================================================
// CUSTOMER ROUTES
// ====================================================

Route::middleware('auth')->group(function () {
    // My Orders
    Route::get('/my-orders',      [Customer\OrderController::class, 'index'])->name('customer.orders');
    Route::get('/my-orders/{id}', [Customer\OrderController::class, 'show'])->name('customer.orders.show');

    // My Profile
    Route::get('/my-profile',             [Customer\ProfileController::class, 'edit'])->name('customer.profile');
    Route::patch('/my-profile',           [Customer\ProfileController::class, 'update'])->name('customer.profile.update');
    Route::patch('/my-profile/password',  [Customer\ProfileController::class, 'updatePassword'])->name('customer.profile.password');

    // Ulasan (Reviews)
    Route::get('/review/create',    [Customer\ReviewController::class, 'create'])->name('review.create');
    Route::post('/review',          [Customer\ReviewController::class, 'store'])->name('review.store');

    // Kupon
    Route::post('/coupon/apply',    [Customer\CouponController::class, 'apply'])->name('coupon.apply');

    // Poin Loyalitas
    Route::get('/my-points',          [Customer\PointsController::class, 'index'])->name('points.index');
    Route::post('/points/calculate',  [Customer\PointsController::class, 'calculate'])->name('points.calculate');

    // Midtrans Payment
    Route::post('/payment/snap/{order}',    [Customer\PaymentController::class, 'createSnap'])->name('payment.snap');

    // Wishlist
    Route::get('/wishlist',            [Customer\WishlistController::class, 'index'])->name('wishlist.index');
    Route::post('/wishlist/toggle',    [Customer\WishlistController::class, 'toggle'])->name('wishlist.toggle');
    Route::delete('/wishlist/{id}',    [Customer\WishlistController::class, 'destroy'])->name('wishlist.destroy');
    Route::get('/api/wishlist/status', [Customer\WishlistController::class, 'status'])->name('wishlist.status');
});

require __DIR__ . '/auth.php';

// ====================================================
// PROFILE ROUTES (Breeze-compatible)
// ====================================================

Route::middleware('auth')->group(function () {
    Route::get('/profile',    [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile',  [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});
