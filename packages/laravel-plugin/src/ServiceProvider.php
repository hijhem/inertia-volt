<?php

declare(strict_types=1);

namespace InertiaInline\Laravel;

use Illuminate\Routing\RouteRegistrar;
use Illuminate\Support\Facades\Context;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider as BaseServiceProvider;
use InertiaInline\Laravel\Routing\PendingInertiaPageRegistration;

class ServiceProvider extends BaseServiceProvider
{
    public function boot(): void
    {
        Route::macro('inertiaPage', function (string $component) {
            Context::addHidden('inertia:component', $component);
            $path = app_path('../resources/js/Pages/' . $component . '.inertia.vue');

            $routeRegistrar = new RouteRegistrar(app('router'));

            return new PendingInertiaPageRegistration($routeRegistrar, $path);
        });
    }
}