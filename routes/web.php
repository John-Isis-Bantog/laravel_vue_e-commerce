<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\HomeRedirectController;
use App\Http\Controllers\ProductController;
use App\Http\Middleware\IsAdmin;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use Laravel\Fortify\Features;

Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canRegister' => Features::enabled(Features::registration()),
    ]);
})->name('home');

Route::middleware(['auth'])->group(function () {
    Route::prefix('user')->group(function () {
        Route::resource('user', CustomerController::class)->only('index', 'show');
        Route::resource('cart', CartController::class)->only('store', 'destroy', 'index');
        Route::resource('checkout', CheckoutController::class);
        Route::put('/cart/changeQuantity/{id}', [CartController::class, 'changeQuantity'])->name('changeQuantity');
    });
    Route::get('/home', HomeRedirectController::class)->name('homeRedirect');
    Route::get('/dashboard', [CustomerController::class, 'index'])->name('dashboard');
});
Route::middleware(['auth', IsAdmin::class])->group(function () {
    Route::resource('admin', AdminController::class)->except('show');
    Route::resource('category', CategoryController::class)->except('show');
    Route::resource('product', ProductController::class)->except('show');
});
require __DIR__ . '/settings.php';
