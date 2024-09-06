<?php

declare(strict_types=1);

namespace InertiaVolt\Laravel;

use Illuminate\Log\Context\Repository;
use Illuminate\Routing\Router;
use Illuminate\Routing\RouteRegistrar;
use InertiaVolt\Laravel\Routing\PendingInertiaPageRegistration;

class VoltPageRegistry
{
    protected string $pagePath;
    protected string $pageExtension;

    public function __construct(
        protected Router $router,
        protected Repository $context
    ) {
        $this->pagePath = config('inertia-volt.path');
        $this->pageExtension = config('inertia-volt.extension');
    }

    public function page(string $component)
    {
        $this->context->addHidden('inertia:component', $component);

        $path = $this->resolveComponentPath($component);

        $routeRegistrar = new RouteRegistrar($this->router);

        return new PendingInertiaPageRegistration($routeRegistrar, $path);
    }

    private function resolveComponentPath(string $component): string
    {
        return app_path(sprintf(
            '../%s/%s.inertia.%s',
            trim($this->pagePath, '/'),
            $component,
            $this->pageExtension
        ));
    }
}