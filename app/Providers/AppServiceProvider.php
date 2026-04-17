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

        // Useful for Shared Hosting where public/ is often public_html/ or root
        if (file_exists(base_path('../public_html'))) {
            $this->app->usePublicPath(base_path('../public_html'));
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
