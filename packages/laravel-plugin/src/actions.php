<?php

declare(strict_types=1);

namespace InertiaVolt\Laravel;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Routing\Route as RouteItem;
use Illuminate\Support\Facades\Context;
use Illuminate\Support\Facades\Route;
use InertiaVolt\Laravel\Routing\VoltRequestHandler;

function render(Closure|string $handler, string $uri = ''): RouteItem
{
    $component = Context::pullHidden('inertia:component');

    return Route::get($uri, static fn(Request $request) => app(VoltRequestHandler::class)->handle($request, $component, $handler));
}

function post(Closure|string $handler, string $uri = ''): RouteItem
{ 
    return Route::post($uri, $handler);
}

function put(Closure|string $handler, string $uri = ''): RouteItem
{
    return Route::put($uri, $handler);
}

function delete(Closure|string $handler, string $uri): RouteItem
{
    return Route::delete($uri, $handler);
}
