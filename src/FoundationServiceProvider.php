<?php

namespace Matteomeloni\Foundation;

use Illuminate\Support\ServiceProvider;
use Matteomeloni\Foundation\Router\ExtendedApiResource;

class FoundationServiceProvider extends ServiceProvider
{
    /**
     * Perform post-registration booting of services.
     *
     * @return void
     */
    public function boot(): void
    {
        // Publishing is only necessary when using the CLI.
        if ($this->app->runningInConsole()) {
            $this->bootForConsole();
        }
    }

    /**
     * Register any package services.
     *
     * @return void
     */
    public function register(): void
    {
        $this->mergeConfigFrom(__DIR__.'/../config/foundation.php', 'foundation');

        // Register the service the package provides.
        $this->app->singleton('foundation', fn($app) => new Foundation);

        $this->app->singleton('router', ExtendedApiResource::class);
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return ['foundation', 'router'];
    }

    /**
     * Console-specific booting.
     *
     * @return void
     */
    protected function bootForConsole(): void
    {
        // Publishing the configuration file.
        $this->publishes([
            __DIR__.'/../config/foundation.php' => config_path('foundation.php'),
        ], 'foundation.config');
    }
}
