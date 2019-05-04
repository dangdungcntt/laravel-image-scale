<?php

namespace Nddcoder\LaravelImageScale;

use Illuminate\Support\ServiceProvider;

class LaravelImageScaleServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     */
    public function boot()
    {
        if ($this->app->runningInConsole()) {
            $this->publishes([
                __DIR__.'/../config/config.php' => config_path('laravel-image-scale.php'),
            ], 'config');
        }
    }

    /**
     * Register the application services.
     */
    public function register()
    {
        // Automatically apply the package configuration
        $this->mergeConfigFrom(__DIR__.'/../config/config.php', 'laravel-image-scale');

        // Register the main class to use with the facade
        $this->app->singleton('laravel-image-scale', function () {
            return new LaravelImageScale;
        });
    }
}
