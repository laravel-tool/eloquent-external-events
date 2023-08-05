<?php

namespace LaravelTool\EloquentExternalEvents;

use Illuminate\Support\ServiceProvider as BaseServiceProvider;

class ServiceProvider extends BaseServiceProvider
{
    public function register(): void
    {
        $this->mergeConfigFrom(__DIR__.'/../config/eloquent_external_events.php', 'eloquent_external_events');
    }

    public function boot(): void
    {
        $this->registerPublishes();
    }

    protected function registerPublishes(): void
    {
        if (!$this->app->runningInConsole()) {
            return;
        }

        $this->publishes([
            __DIR__.'/../config/eloquent_external_events.php' => config_path('eloquent_external_events.php'),
        ], 'config');
    }
}