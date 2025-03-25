<?php

use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\FitbitController;
use Illuminate\Support\Facades\Route;

Route::post('/login', [AuthenticatedSessionController::class, 'store'])->name('login');
Route::post('/logout', [AuthenticatedSessionController::class, 'destroy'])->name('logout');

Route::middleware('auth:sanctum')->group(function () {
    Route::get('/fitbit/auth', [FitbitController::class, 'redirectToFitbit']);
    Route::get('/fitbit/callback', [FitbitController::class, 'handleFitbitCallback']);
});
