<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\customerController;
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
    Route::resource('user', customerController::class);
    Route::get('/home', HomeRedirectController::class)->name('homeRedirect');
});
Route::middleware(['auth', IsAdmin::class])->group(function () {
    Route::resource('admin', AdminController::class)->except('show');
    Route::resource('category', CategoryController::class)->except('show');
    Route::resource('product', ProductController::class)->except('show');
});
require __DIR__ . '/settings.php';
