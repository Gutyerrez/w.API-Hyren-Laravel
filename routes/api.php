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

    Route::prefix('/changelogs')->group(function() {
        Route::get('/', 'ChangelogsController@index');

        Route::post('/create', 'ChangelogsController@store');

        Route::delete('/delete/{id}', 'ChangelogsController@delete');
    });
});
