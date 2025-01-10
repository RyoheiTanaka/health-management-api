<?php

use App\Http\Controllers\FitBitController;
use App\Http\Controllers\HealthPlanetController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::controller(HealthPlanetController::class)->group(function () {
    Route::get('/healthplanet', 'index');
});

Route::controller(FitBitController::class)->group(function () {
    Route::get('/fitbit', 'index');
});
