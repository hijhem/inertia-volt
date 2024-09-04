<?php

declare(strict_types=1);

namespace InertiaVolt\Laravel;

use Illuminate\Routing\RouteRegistrar;
use Illuminate\Support\Facades\Context;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider as BaseServiceProvider;
use InertiaVolt\Laravel\Routing\PendingInertiaPageRegistration;

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

        $pagePath = config('inertia-volt.path');
        $pageExtension = config('inertia-volt.extension');

        Route::macro('inertiaPage', function (string $component) use ($pagePath, $pageExtension) {
            Context::addHidden('inertia:component', $component);

            $path = app_path(sprintf(
                '../%s/%s.inertia.%s',
                trim($pagePath, '/'),
                $component,
                $pageExtension
            ));

            $routeRegistrar = new RouteRegistrar(app('router'));

            return new PendingInertiaPageRegistration($routeRegistrar, $path);
        });
    }
}