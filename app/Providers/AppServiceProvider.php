<?php

namespace App\Providers;

use App\Contracts\StatisticsContract;
use App\Service\StatisticsService;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        app()->bind(StatisticsContract::class, function () {
            return app()->make(StatisticsService::class);
        });
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
