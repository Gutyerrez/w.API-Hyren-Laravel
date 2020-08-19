<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function() {
    return response()->json([
        'Hyren API Version' => '0.1-ALPHA'
    ]);
});

Route::middleware('authentication')->group(function() {
    Route::prefix('/users')->group(function() {
        Route::post('/authenticate', 'MojangController@store');

        Route::get('/groups/staff', 'StaffController@index');
    });
});
