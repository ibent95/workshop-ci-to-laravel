<?php

namespace App\Providers;

use App\Services\CommonService;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        // Load UtilityService
        $this->app->singleton('common', function ($app) {
            return new CommonService(
                httpClient: $app->make('Illuminate\Support\Facades\Http'),
            );
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
