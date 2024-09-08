<?php

declare(strict_types=1);

namespace InertiaVolt\Laravel;

use Exception;
use Illuminate\Log\Context\Repository;
use Illuminate\Routing\Router;
use Illuminate\Routing\RouteRegistrar;
use InertiaVolt\Laravel\Routing\PendingInertiaPageRegistration;

class InertiaVoltManager
{
    protected string $pagePath;

    protected string $pageExtension;

    public function __construct(
        protected Router $router,
        protected PageContext $pageContext,
        protected Repository $context,
    ) {
        $this->pagePath = config('inertia-volt.path', fn() => resource_path('js/Pages'));
        $this->pageExtension = config('inertia-volt.extension', 'vue');
    }

    public function page(string $component): PendingInertiaPageRegistration
    {
        $this->pageContext->setComponent($component);

        $path = $this->resolveComponentPath($component);

        if (!file_exists($path)) {
            throw new Exception("Component $component not found.");
        }

        $routeRegistrar = new RouteRegistrar($this->router);

        return new PendingInertiaPageRegistration($this->pageContext, $routeRegistrar, $path);
    }

    private function resolveComponentPath(string $component): string
    {
        return sprintf(
            '%s/%s.inertia.%s',
            rtrim($this->pagePath, '/'),
            $component,
            $this->pageExtension,
        );
    }
}
