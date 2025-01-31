<?php

use App\Http\Controllers\Api\FitbitBadgeLogController;
use App\Http\Controllers\Api\FitbitFatLogController;
use App\Http\Controllers\Api\FitbitSleepLogController;
use App\Http\Controllers\Api\FitbitWeightLogController;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Route;

Route::middleware(['schedule-run', 'auth:sanctum'])->group(function () {
    Route::get('/schedule-run', function () {
        Artisan::call('schedule:run');
        return response()->json(['message' => 'Schedule run executed successfully'], 200);
    });
});

Route::middleware('auth:sanctum')->group(function () {
    Route::get('/auth/check', function () {
        return response()->json(['authenticated' => true], 200);
    });
    Route::controller(FitbitWeightLogController::class)->group(function () {
        Route::get('/fitbit/weights/{fitbitWeightLogId}', 'show');
        Route::get('/fitbit/weights', 'index');
    });
    Route::controller(FitbitFatLogController::class)->group(function () {
        Route::get('/fitbit/fats/{fitbitFatLogId}', 'show');
        Route::get('/fitbit/fats', 'index');
    });
    Route::controller(FitbitSleepLogController::class)->group(function () {
        Route::get('/fitbit/sleeps/{fitbitSleepLogId}', 'show');
        Route::get('/fitbit/sleeps', 'index');
    });
    Route::controller(FitbitBadgeLogController::class)->group(function () {
        Route::get('/fitbit/badges/{fitbitBadgeLogId}', 'show');
        Route::get('/fitbit/badges', 'index');
    });
});
