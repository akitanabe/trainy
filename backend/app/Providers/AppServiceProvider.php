<?php

namespace App\Providers;

use App\Services\MobileSuicaService;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->singleton(MobileSuicaService::class, function ($app) {
            return new MobileSuicaService(
                $app->make(\App\Repositories\MobileSuicaRepository::class)
            );
        });
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
    }
}
