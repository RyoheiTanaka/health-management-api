<?php

use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\FitbitAuthController;
use App\Http\Controllers\FitbitCallbackController;
use Illuminate\Support\Facades\Route;

Route::post('/login', [AuthenticatedSessionController::class, 'store'])->name('login');
Route::post('/logout', [AuthenticatedSessionController::class, 'destroy'])->name('logout');

Route::middleware('auth:sanctum')->group(function () {
    Route::get('/fitbit/auth', FitbitAuthController::class);
});

Route::get('/fitbit/callback', FitbitCallbackController::class);
