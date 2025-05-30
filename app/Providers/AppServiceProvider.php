<?php

namespace App\Providers;

use App\Models\PersonalAccessToken;
use App\Repositories\Eloquent\AuthRepository;
use App\Repositories\Eloquent\FitbitBadgeLogRepository;
use App\Repositories\Eloquent\FitbitFatLogRepository;
use App\Repositories\Eloquent\FitbitSleepLogRepository;
use App\Repositories\Eloquent\FitbitWeightLogRepository;
use App\Repositories\AuthRepositoryInterface;
use App\Repositories\FitbitBadgeLogRepositoryInterface;
use App\Repositories\FitbitFatLogRepositoryInterface;
use App\Repositories\FitbitSleepLogRepositoryInterface;
use App\Repositories\FitbitWeightLogRepositoryInterface;
use Laravel\Sanctum\Sanctum;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(AuthRepositoryInterface::class, AuthRepository::class);
        $this->app->bind(FitbitBadgeLogRepositoryInterface::class, FitbitBadgeLogRepository::class);
        $this->app->bind(FitbitFatLogRepositoryInterface::class, FitbitFatLogRepository::class);
        $this->app->bind(FitbitSleepLogRepositoryInterface::class, FitbitSleepLogRepository::class);
        $this->app->bind(FitbitWeightLogRepositoryInterface::class, FitbitWeightLogRepository::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Sanctum::usePersonalAccessTokenModel(PersonalAccessToken::class);
    }
}
