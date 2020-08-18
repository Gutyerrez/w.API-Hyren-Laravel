<?php

namespace App\Http;

use Illuminate\Foundation\Http\Kernel as HttpKernel;

class Kernel extends HttpKernel
{
    protected $middleware = [ ];

    protected $middlewareGroups = [
        'api' => [
        ],
    ];

    protected $routeMiddleware = [
        'authentication' => \App\Http\Middleware\Authentication::class,
    ];
}
