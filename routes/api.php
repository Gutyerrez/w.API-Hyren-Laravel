<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

/*
 * Default base route showing api version
 */

Route::get('/', function() {
    return response()->json([
        'Hyren API Version' => '0.1-ALPHA'
    ]);
});
