<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function() {
    return response()->json([
        'Hyren API Version' => '0.1-ALPHA'
    ], 200);
});

Route::post('/authentication/generate', 'AuthenticationController@store');

Route::middleware('authentication')->group(function() {
    Route::prefix('/users')->group(function() {
        Route::get('/', 'UsersController@index');

        Route::get('/{user_id}', 'UsersController@show');

        Route::post('/authenticate', 'MojangController@store');

        Route::post('/discord', 'DiscordController@store');

        Route::get('/groups/staff', 'StaffController@index');

        Route::get('/groups/{user_id}', 'UsersGroupsDueController@show');

        Route::post('/groups/create', 'UsersGroupsDueController@store');

        Route::get('/punishments/{user_id}', 'UsersPunishmentsController@show');
    });

    Route::prefix('/changelogs')->group(function() {
        Route::get('/', 'ChangelogsController@index');

        Route::post('/create', 'ChangelogsController@store');

        Route::delete('/delete/{id}', 'ChangelogsController@delete');
    });

    Route::resource('/categories', 'CategoriesController')->only([
        'index', 'show', 'store', 'update', 'delete'
    ]);

    Route::resource('/changelogs', 'ChangelogsController')->only([
        'index', 'store', 'delete'
    ]);

    Route::prefix('/forums/{category_id}', 'ForumsController@index');

    Route::prefix('/threads')->group(function() {
        Route::resource('/', 'ThreadsController')->only([
            'index', 'view', 'store', 'update', 'delete'
        ]);

        Route::resource('/posts', 'PostsController')->only([
            'index', 'store', 'update', 'delete'
        ]);
    });

    Route::resource('/shorts/urls', 'ShortedUrlController')->only([
        'index', 'show', 'store', 'update', 'delete'
    ]);

    Route::prefix('/punishments')->group(function() {
        Route::get('/lasts', 'UsersPunishmentsController@index');
    });
});
