<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function() {
    return response()->json([
        'Hyren API Version' => '0.1-ALPHA'
    ], 200);
});

Route::get('/punishments/lasts', 'UsersPunishmentsController@index');

Route::post('/authentication/generate', 'AuthenticationController@store');

Route::middleware('authentication')->group(function() {
    Route::prefix('/users')->group(function() {
        Route::get('/', 'UsersController@index');

        Route::get('/{user_id}', 'UsersController@show');

        Route::get('/{user_id}/punishments', 'UsersPunishmentsController@show');

        Route::get('/{user_id}/groups', 'UsersGroupsDueController@show');

        Route::get('/groups/staff', 'StaffController@index');

        Route::post('/discord', 'DiscordController@store');

        Route::post('/authenticate', 'MojangController@store');

        Route::post('/groups/create', 'UsersGroupsDueController@store');
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
        Route::get('/{forum_id}', 'ThreadsController@index');

        Route::get('/{forum_id}/{thread_id}', 'ThreadsController@show');

        Route::put('/{forum_id}/{thread_id}', 'ThreadsController@update');

        Route::post('/create', 'ThreadsController@store');

        Route::delete('/delete/{thread_id}', 'ThreadsController@delete');

        Route::resource('/posts', 'PostsController')->only([
            'index', 'store', 'update', 'delete'
        ]);
    });

    Route::resource('/shorts/urls', 'ShortedUrlController')->only([
        'index', 'show', 'store', 'update', 'delete'
    ]);
});
