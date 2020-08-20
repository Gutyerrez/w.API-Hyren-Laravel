<?php

return [
    'driver' => 'lifetime',
    'lifetime' => 120,
    'expire_on_close' => false,
    'encrypt' => false,
    'files' => storage_path('framework/sessions'),
    'connection' => null,
    'table' => 'sessions',
    'path' => '/',
    'domain' => null,
    'secure' => 'SESSION_SECURE_COOKIE',
    'http_only' => true,
    'same_site' => 'lax',
];
