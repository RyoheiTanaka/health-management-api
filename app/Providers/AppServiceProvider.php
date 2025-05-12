<?php

namespace App\Providers;

use App\Models\PersonalAccessToken;
use App\Repositories\Eloquent\FitbitBadgeLogRepository;
use App\Repositories\Eloquent\FitbitFatLogRepository;
use App\Repositories\Eloquent\FitbitWeightLogRepository;
use App\Repositories\FitbitBadgeLogRepositoryInterface;
use App\Repositories\FitbitFatLogRepositoryInterface;
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
        $this->app->bind(FitbitBadgeLogRepositoryInterface::class, FitbitBadgeLogRepository::class);
        $this->app->bind(FitbitFatLogRepositoryInterface::class, FitbitFatLogRepository::class);
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
