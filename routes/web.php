<?php

use App\Http\Controllers\Web\AdminUserController;
use App\Http\Controllers\Web\AdminController;
use App\Http\Controllers\Web\CartController;
use App\Http\Controllers\Web\CategoryController;
use App\Http\Controllers\Web\CheckoutController;
use App\Http\Controllers\Web\CustomerController;
use App\Http\Controllers\Web\HomeRedirectController;

use App\Http\Controllers\Web\ProductController;
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
        Route::resource('products', CustomerController::class)->only('index', 'show');
        Route::resource('checkout', CheckoutController::class);
        // route group without group() and prefix
        {
            Route::resource('cart', CartController::class)->only('store', 'destroy', 'index');
            Route::put('/cart/updateQuantity/{cartItem}', [CartController::class, 'updateQuantity'])->name('updateQuantity');
            Route::put('/cart/select/{cartItem}', [CartController::class, 'toggleIsSelected'])->name('toggleIsSelected');
        };
    });
    Route::get('/home', HomeRedirectController::class)->name('homeRedirect');
    Route::get('/dashboard', [CustomerController::class, 'index'])->name('dashboard');
});
Route::middleware(['auth', IsAdmin::class])->group(function () {
    Route::resource('admin', AdminController::class)->except('show');
    Route::resource('category', CategoryController::class)->except('show');
    Route::resource('product', ProductController::class)->except('show');
    Route::resource('Users', AdminUserController::class)->only('index', 'show');
});
require __DIR__ . '/settings.php';
