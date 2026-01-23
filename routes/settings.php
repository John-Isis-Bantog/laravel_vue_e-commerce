<?php

use App\Http\Controllers\Settings\AddressesController;
use App\Http\Controllers\Settings\PasswordController;
use App\Http\Controllers\Settings\ProfileController;
use App\Http\Controllers\Settings\TwoFactorAuthenticationController;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::middleware('auth')->group(function () {
    Route::redirect('settings', '/settings/profile');

    Route::get('settings/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('settings/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('settings/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::get('settings/password', [PasswordController::class, 'edit'])->name('user-password.edit');

    Route::put('settings/password', [PasswordController::class, 'update'])
        ->middleware('throttle:6,1')
        ->name('user-password.update');

    Route::get('settings/appearance', function () {
        return Inertia::render('settings/Appearance');
    })->name('appearance.edit');

    Route::get('settings/two-factor', [TwoFactorAuthenticationController::class, 'show'])
        ->name('two-factor.show');

    Route::get('settings/addresses', [AddressesController::class, 'index'])->name('addresses.index');
    Route::get('settings/addresses/edit/{id}', [AddressesController::class, 'edit'])->name('addresses.edit');
    Route::put('settings/addresses/{address}', [AddressesController::class, 'update'])->name('addresses.update');
    Route::post('settings/addresses', [AddressesController::class, 'store'])->name('addresses.store');
    Route::delete('settings/addresses/{id}', [AddressesController::class, 'destroy'])->name('addresses.destroy');
});
