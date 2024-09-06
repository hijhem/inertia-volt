<?php

declare(strict_types=1);

namespace InertiaVolt\Laravel;

use Illuminate\Support\ServiceProvider as BaseServiceProvider;

class ServiceProvider extends BaseServiceProvider
{
    public function register()
    {
        $this->mergeConfigFrom(
            __DIR__ . '/../config/inertia-volt.php',
            'inertia-volt'
        );
    }

    public function boot(): void
    {
        $this->publishes([
            __DIR__.'/../config/inertia-volt.php' => config_path('inertia-volt'),
        ]);
    }
}