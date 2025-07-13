<?php

use Livewire\Volt\Volt;
use Illuminate\Support\Facades\Route;

// --- Imports Controllers Anda ---
use App\Http\Controllers\HomepageController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProductCategoryController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CustomerAuthController;
use App\Http\Controllers\ThemeController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\OrderController; // Pastikan ini di-import!
use App\Http\Controllers\ApiController;
// --- Akhir Imports ---

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

// --- Public Routes (Tidak memerlukan login) ---

// Homepage, Products, Categories
Route::get('/', [HomepageController::class, 'index'])->name('home');
Route::get('products', [HomepageController::class, 'products']);
Route::get('product/{slug}', [HomepageController::class, 'product'])->name('product.show');
Route::get('categories',[HomepageController::class, 'categories']);
Route::get('category/{slug}', [HomepageController::class, 'category']);

// Cart dan Checkout (GET - untuk menampilkan halaman)
// Ini biasanya bisa diakses tanpa login untuk melihat isi keranjang/form checkout
Route::get('cart', [HomepageController::class, 'cart'])->name('cart.index');
Route::get('checkout', [HomepageController::class, 'checkout'])->name('checkout.index');

// --- Routes yang Membutuhkan Login Customer ---
Route::group(['middleware' => ['is_customer_login']], function() {

    // Cart Actions (POST, DELETE, PATCH)
    Route::controller(CartController::class)->group(function () {
        Route::post('cart/add', 'add')->name('cart.add');
        Route::delete('cart/remove/{id}', 'remove')->name('cart.remove');
        Route::patch('cart/update/{id}', 'update')->name('cart.update');
    });

    // Checkout Store (POST - untuk memproses pesanan)
    Route::post('checkout', [CheckoutController::class, 'store'])->name('checkout.store');

    // Tambahkan rute lain yang memerlukan login customer di sini jika ada
    // Contoh: customer profile, order history, dll.

});

// --- Customer Authentication Routes ---
Route::group(['prefix' => 'customer'], function() {
    Route::controller(CustomerAuthController::class)->group(function(){
        Route::group(['middleware' => 'check_customer_login'], function(){
            // Tampilkan halaman login
            Route::get('login','login')->name('customer.login');
            // Aksi login
            Route::post('login','store_login')->name('customer.store_login');
            // Tampilkan halaman register
            Route::get('register','register')->name('customer.register');
            // Aksi register
            Route::post('register','store_register')->name('customer.store_register');
        });
        
        // Aksi logout
        Route::post('logout','logout')->name('customer.logout');
    });
});

// --- Dashboard / Admin Routes (Membutuhkan login admin/user) ---
Route::group(['prefix' => 'dashboard', 'middleware' => ['auth', 'verified']], function(){
    Route::get('/',[DashboardController::class,'index'])->name('dashboard');

    Route::resource('categories', ProductCategoryController::class);
    Route::resource('products', ProductController::class);
    Route::resource('themes', ThemeController::class);
    
    // --- PERBAIKAN PENEMPATAN RUTE ORDERS DI SINI ---
    Route::resource('orders', OrderController::class); // Ini akan membuat index, create, store, show, edit, update, destroy
    // Jika Anda ingin rute updateStatus terpisah, Anda bisa menambahkannya setelah resource
    Route::patch('orders/{order}/status', [OrderController::class, 'updateStatus'])->name('orders.updateStatus');
    // --- AKHIR PERBAIKAN ---

    // Tambahkan resource atau rute lain untuk dashboard di sini
});

// --- Settings Routes (Menggunakan Volt, membutuhkan login user) ---
Route::middleware(['auth'])->group(function () {
    Route::redirect('settings', 'settings/profile');

    Volt::route('settings/profile', 'settings.profile')->name('settings.profile');
    Volt::route('settings/password', 'settings.password')->name('settings.password');
    Volt::route('settings/appearance', 'settings.appearance')->name('settings.appearance');
});

// --- Auth Routes Laravel Breeze/Jetstream (jika digunakan) ---
require __DIR__.'/auth.php';