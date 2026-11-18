<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Foundation\Vite;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->singleton(Vite::class, function ($app) {
            return new class extends Vite {
                public function isRunningHot()
                {
                    // Jika file build terkompilasi ada di public/build/manifest.json,
                    // selalu prioritaskan file terkompilasi agar styling tidak pernah rusak
                    // baik diakses dari localhost, 127.0.0.1, maupun HP lewat Wi-Fi.
                    if (is_file($this->manifestPath($this->buildDirectory))) {
                        return false;
                    }

                    return parent::isRunningHot();
                }
            };
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
