<?php

namespace App\Providers;

use App\Services\Msg91Service;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->singleton(Msg91Service::class, function ($app) {
            return new Msg91Service();
        });

        // Robust Shared Hosting Vite Fix
        if (!$this->app->runningInConsole()) {
            if (file_exists(base_path('public_html/build/manifest.json'))) {
                $this->app->usePublicPath(base_path('public_html'));
            } elseif (file_exists(base_path('../public_html/build/manifest.json'))) {
                $this->app->usePublicPath(base_path('../public_html'));
            }
        }
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
