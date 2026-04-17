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

        // Improved Shared Hosting Vite Fix
        if ($this->app->environment('production')) {
            if (file_exists(base_path('build/manifest.json'))) {
                $this->app->usePublicPath(base_path());
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
