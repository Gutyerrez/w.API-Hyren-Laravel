<?php

return [
    'default' => env('DB_CONNECTION'),
    'connections' => [
        'pgsql' => [
            'driver' => 'pgsql',
            'host' => env('DB_HOST'),
            'port' => env('DB_PORT'),
            'database' => env('DB_DATABASE'),
            'username' => env('DB_USERNAME'),
            'password' => env('DB_PASSWORD'),
            'schema' => env('DB_SCHEMA'),
        ],
    ],
    'migrations' => 'migrations',
    'redis' => [
    ],
];
