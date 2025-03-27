<?php

namespace Chipneedham\LaravelGovee;

use Illuminate\Support\ServiceProvider;

class GoveeApiServiceProvider extends ServiceProvider
{

    /**
     * @inheritDoc
     */
    public function register(): void
    {
        $this->mergeConfigFrom(__DIR__ . '/../config/govee.php', 'govee');
        $this->app->singleton('govee-api', function ($app) {
            return new GoveeApiClient($app['config']['govee']['api_key']);
        });
    }


    public function boot(): void
    {
        $this->publishes([
            __DIR__ . '/../config/govee.php' => config_path('govee.php'),
        ], 'config');
    }
}