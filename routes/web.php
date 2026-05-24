<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\OwnerController;
use App\Http\Controllers\LivestockController;
use App\Http\Controllers\VaccinationController;
use App\Http\Controllers\TradeController;
use App\Http\Controllers\UserController;

// Root redirect
Route::get('/', fn() => redirect()->route('login'));

// Authenticated routes
Route::middleware(['auth'])->group(function () {

    // Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Owners — admin and authority only
    // Owners — admin, authority AND farmer can manage their own
    Route::middleware(['role:admin,authority,farmer'])->group(function () {
        Route::resource('owners', OwnerController::class);
    });

    // Livestock — all roles but filtered by ownership
    Route::resource('livestock', LivestockController::class);
    Route::post('livestock/{id}/transfer', [LivestockController::class, 'transfer'])
        ->name('livestock.transfer')
        ->middleware('role:admin');

    // Vaccinations — all roles but filtered
    Route::resource('vaccinations', VaccinationController::class);

    // Trades — all roles but filtered
    Route::resource('trades', TradeController::class);

    // Users — admin only
    Route::middleware(['role:admin'])->group(function () {
        Route::resource('users', UserController::class);
    });

});

require __DIR__.'/auth.php';