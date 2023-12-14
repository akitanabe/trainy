<?php

declare(strict_types=1);

namespace App\Providers;

use App\Services\MobilesuicaService;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->singleton(MobilesuicaService::class, function ($app) {
            return new MobilesuicaService(
                $app->make(\App\Repositories\MobilesuicaRepository::class)
            );
        });
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void {}
}
