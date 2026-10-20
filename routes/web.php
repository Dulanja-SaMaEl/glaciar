<?php

use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Customer\HomeController;
use App\Http\Controllers\Customer\ProductController;
use App\Http\Controllers\Customer\CartController;
use App\Http\Controllers\Customer\CheckoutController;
use App\Http\Controllers\Customer\OrderTrackingController;
use App\Http\Controllers\Customer\AccountController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Customer-facing website routes.
|
*/
// ------------------------------------------
// AUTHENTICATION ROUTES (The Missing Piece)
// ------------------------------------------
Route::middleware('guest')->group(function () {
    Route::get('login', [AuthController::class, 'create'])->name('login');
    Route::post('login', [AuthController::class, 'store']);
    Route::get('register', [AuthController::class, 'registerCreate'])->name('register');
    Route::post('register', [AuthController::class, 'registerStore']);
});

Route::post('logout', [AuthController::class, 'destroy'])
    ->middleware('auth')
    ->name('logout');

use App\Http\Controllers\Customer\ContactController;

Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/about', fn () => view('customer.about'))->name('about');
Route::get('/contact', [ContactController::class, 'index'])->name('contact');
Route::post('/contact', [ContactController::class, 'store'])->name('contact.store');
Route::get('/terms', fn () => view('customer.terms'))->name('terms');
Route::get('/privacy', fn () => view('customer.privacy'))->name('privacy');
Route::get('/sustainability', fn () => view('customer.sustainability'))->name('sustainability');
Route::get('/analysis', fn () => view('customer.analysis'))->name('analysis');
Route::get('/faq', fn () => view('customer.faq'))->name('faq');

Route::get('/collection', [ProductController::class, 'collection'])->name('collection');
Route::get('/shop', [ProductController::class, 'index'])->name('shop');

Route::prefix('products')->name('products.')->group(function () {
    Route::get('/', [ProductController::class, 'index'])->name('index');
    Route::get('/{product}', [ProductController::class, 'show'])->name('show');
});

Route::prefix('cart')->name('cart.')->group(function () {
    Route::get('/', [CartController::class, 'index'])->name('index');
    Route::post('/add', [CartController::class, 'store'])->name('store');
    Route::patch('/update/{id}', [CartController::class, 'update'])->name('update');
    Route::delete('/remove/{id}', [CartController::class, 'destroy'])->name('destroy');
});

// Authentication Routes (Laravel Breeze)
// require __DIR__.'/auth.php';

// Authenticated Customer Routes
Route::middleware('auth')->group(function () {
    Route::get('/checkout', [CheckoutController::class, 'index'])->name('checkout.index');
    Route::post('/checkout', [CheckoutController::class, 'store'])->name('checkout.store');
    Route::get('/checkout/success', [CheckoutController::class, 'success'])->name('checkout.success');

    Route::get('/orders/{order}/track', [OrderTrackingController::class, 'show'])->name('orders.track');

    Route::prefix('account')->name('account.')->group(function () {
        Route::get('/', [AccountController::class, 'index'])->name('index');
        Route::get('/orders', [AccountController::class, 'orders'])->name('orders');
        Route::get('/orders/{id}', [AccountController::class, 'showOrder'])->name('orders.show');
        Route::get('/orders/{id}/invoice', [AccountController::class, 'invoice'])->name('orders.invoice');
        Route::put('/profile', [AccountController::class, 'updateProfile'])->name('profile.update');
    });
});


require base_path('routes/admin.php');
