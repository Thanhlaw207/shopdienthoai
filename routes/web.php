<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\LoginController;
use App\Models\Product;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// ================= ROOT =================
Route::get('/', function () {
    return auth()->check()
        ? redirect()->route('home')
        : redirect()->route('landing');
});

// ================= AUTH =================
Route::get('/landing', function () {
    return view('auth.landing');
})->name('landing');

// ---------- LOGIN ----------
Route::get('/login', [LoginController::class, 'showLoginForm'])->middleware('guest')->name('login');
Route::post('/login', [LoginController::class, 'login'])->middleware('guest');

// ---------- REGISTER ----------
Route::get('/register', [RegisterController::class, 'showRegisterForm'])->middleware('guest')->name('register');
Route::post('/register', [RegisterController::class, 'register'])->middleware('guest');

// ---------- OTP ----------
Route::get('/verify-otp', [RegisterController::class, 'showVerifyOtpForm'])->middleware('guest')->name('otp.view');
Route::post('/verify-otp', [RegisterController::class, 'verifyOtp'])->middleware('guest')->name('otp.verify');
Route::post('/resend-otp', [RegisterController::class, 'resendOtp'])->middleware('guest')->name('otp.resend');

// ---------- LOGOUT ----------
Route::post('/logout', [LoginController::class, 'logout'])->middleware('auth')->name('logout');

// ================= AUTHENTICATED =================

Route::middleware(['auth'])->group(function () {
    
    // ---------- HOME ----------
    Route::get('/home', [HomeController::class, 'index'])->name('home');

    // ---------- THỐNG KÊ (PHẢI ĐẶT TRƯỚC RESOURCE) ----------
    // Đặt ở đây để Laravel không nhầm "/thong-ke" là ID của sản phẩm
    Route::get('/products/thong-ke', [ProductController::class, 'thongKe'])->name('products.thongke');

    // ---------- PRODUCTS ----------
    Route::resource('products', ProductController::class);
    

    Route::get('/shop', function () {
    // 1. Lấy tất cả sản phẩm trong database và nhóm lại theo cột 'brand' (hãng)
    // Chính dòng này sẽ tạo ra biến $categories mà giao diện đang đòi hỏi
    $categories = Product::all()->groupBy('brand');

    // 2. Trả về view và đính kèm biến $categories theo
    return view('client.index', compact('categories'));
})->name('shop.index');
});