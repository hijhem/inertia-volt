<?php

use function InertiaVolt\Laravel\render;

render(fn() => [
    'message' => 'Hello from Inertia Volt',
], 'volt')->name('volt');