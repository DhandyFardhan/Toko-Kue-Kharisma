<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ReviewController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\MidtransController;

// Halaman Publik
Route::get('/', [AuthController::class, 'showHome'])->name('home');
Route::get('/menu', [ProductController::class, 'index'])->name('menu');
Route::get('/promo', fn() => view('promo'))->name('promo');
Route::get('/kontak', fn() => view('kontak'))->name('kontak');
Route::get('/ulasan', [ReviewController::class, 'index'])->name('reviews.index');
Route::post('/reviews', [ReviewController::class, 'store'])->name('reviews.store');
Route::get('/api/cart/count', [CartController::class, 'count'])->name('api.cart.count');

// Auth (Guest)
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login'])->name('login.submit');
    Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register', [AuthController::class, 'register'])->name('register.submit');
});

// Auth (Logged In)
Route::middleware('auth')->group(function () {
    // Profil & Keamanan
    Route::get('/profile', [AuthController::class, 'showProfile'])->name('profile');
    Route::put('/profile', [AuthController::class, 'updateProfile'])->name('profile.update');
    Route::put('/profile/password', [AuthController::class, 'updatePassword'])->name('profile.password');
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

    // Keranjang & Checkout
    Route::get('/cart', [CartController::class, 'index'])->name('cart');
    Route::post('/cart/add', [CartController::class, 'add'])->name('cart.add');
    Route::post('/cart/update', [CartController::class, 'update'])->name('cart.update');
    Route::post('/cart/remove', [CartController::class, 'remove'])->name('cart.remove');
    Route::post('/cart/clear', [CartController::class, 'clear'])->name('cart.clear');
    Route::get('/cart/summary', [CartController::class, 'summary'])->name('cart.summary');
    
    // Pesanan & Pembayaran (DI SINI PERUBAHANNYA)
Route::post('/order/store', [OrderController::class, 'store'])->name('checkout'); 
Route::post('/checkout', [OrderController::class, 'store'])->name('checkout');
    Route::get('/riwayat', [OrderController::class, 'history'])->name('riwayat'); // Jalur ke riwayat
    Route::get('/api/orders/history', [OrderController::class, 'historyJson'])->name('api.orders.history');
    
    Route::get('/payment/upload/{orderId}', [PaymentController::class, 'show'])->name('payment.upload');
    Route::post('/payment/upload', [PaymentController::class, 'uploadProof'])->name('payment.upload-proof');
});


Route::post('/midtrans/notification', [MidtransController::class, 'notification'])->name('midtrans.notification');