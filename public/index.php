<?php

define('LARAVEL_START', microtime(true));
define('INTERNAL_SERVER_ERROR', 'Internal server error');
define('DEFAULT_PER_PAGE', 10);

require __DIR__.'/../vendor/autoload.php';

$app = require_once __DIR__.'/../bootstrap/app.php';

$kernel = $app->make(Illuminate\Contracts\Http\Kernel::class);

$response = $kernel->handle(
    $request = Illuminate\Http\Request::capture()
);

$response->send();

$kernel->terminate($request, $response);
