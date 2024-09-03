<?php

declare(strict_types=1);

namespace InertiaInline\Laravel\Routing;

use Illuminate\Routing\RouteRegistrar;
use Illuminate\Support\Arr;

class PendingInertiaPageRegistration
{
    protected array $attributes = [];

    public function __construct(protected RouteRegistrar $registrar, protected string $component)
    {
    }

    public function name(string $name): self
    {
        $this->attributes['name'] = $name;

        return $this;
    }

    public function prefix(string $prefix): self
    {
        $this->attributes['prefix'] = $prefix;

        return $this;
    }

    public function middleware(array|string $middleware): self
    {
        $this->attributes['middleware'] = Arr::wrap($middleware);

        return $this;
    }

    public function __destruct()
    {
        $path = $this->component;

        if (isset($this->attributes['middleware'])) {
            $this->registrar->middleware($this->attributes['middleware']);
        }

        if (isset($this->attributes['name'])) {
            $this->registrar->name($this->attributes['name']);
        }

        if (isset($this->attributes['prefix'])) {
            $this->registrar->prefix($this->attributes['prefix']);
        }

        $this->registrar->group(static function () use ($path) {
            ob_start();
            require $path;
            ob_end_clean();
        });
    }
}