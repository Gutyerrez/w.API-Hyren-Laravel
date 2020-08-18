<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function() {
    return response()->json([
        'Hyren API Version' => '0.1-ALPHA'
    ]);
});
