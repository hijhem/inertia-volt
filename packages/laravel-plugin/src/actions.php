<?php

declare(strict_types=1);

namespace InertiaInline\Laravel;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Routing\Route as RouteItem;
use Illuminate\Support\Facades\Context;
use Illuminate\Support\Facades\Route;
use ReflectionFunction;

function render(Closure $handler, string $uri = ''): RouteItem
{
    $component = Context::pullHidden('inertia:component');

    $wrap = static function (Request $request) use ($handler, $component) {
        $route = $request->route();
        $parameters = $route->resolveMethodDependencies(
            $route->parametersWithoutNulls(),
            new ReflectionFunction($handler)
        );

        $props = $handler(...array_values($parameters));

        return inertia($component . '.inertia', $props);
    };

    return Route::get($uri, $wrap);
}

function post(Closure $handler, string $uri = ''): RouteItem
{ 
    return Route::post($uri, $handler);
}

function put(Closure $handler, string $uri = ''): RouteItem
{
    return Route::put($uri, $handler);
}

function delete(Closure $handler, string $uri): RouteItem
{
    return Route::delete($uri, $handler);
}
