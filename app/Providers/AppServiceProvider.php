<?php

namespace App\Providers;

use Illuminate\Support\Facades\Vite;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\URL;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Vite::prefetch(concurrency: 3);
        if (env('APP_ENV') === 'production') {
            URL::forceScheme('https');            
        }
        // Force Vite to use production assets
        if (!app()->isLocal()) {
            \Illuminate\Support\Facades\Config::set('vite.build_path', 'build');
        }
    }
}
