<?php

declare(strict_types=1);

namespace InertiaVolt\Laravel\Routing;

use Closure;
use Exception;
use Illuminate\Contracts\Container\Container;
use ReflectionFunction;
use ReflectionFunctionAbstract;
use ReflectionMethod;

class PageHandlerFactory
{
    public function __construct(
        private Container $container,
    ) {  
    }

    /**
     * @return array<Closure, ReflectionFunctionAbstract>
     */
    public function createHandler(Closure|string $handler): array
    {
        if (is_string($handler) && class_exists($handler)) {
            $handler = $this->container->get($handler);

            if (!is_callable($handler)) {
                throw new Exception('Handler class should be an invokable class');
            }

            return [$handler, new ReflectionMethod($handler, '__invoke')];
        }

        return [$handler, new ReflectionFunction($handler)];
    }
}