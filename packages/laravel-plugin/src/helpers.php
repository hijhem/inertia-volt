<?php

declare(strict_types=1);

if (! function_exists('resolve_inertia_component')) {
    /**
     * @param array{component: string} $page
     */
    function resolve_inertia_component(array $page): string
    {
        $pagePath = config('inertia-volt.path');
        $extension = config('inertia-volt.extension');

        return "$pagePath/{$page['component']}.$extension";
    }
}
