<?php

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

$api = app('Dingo\Api\Routing\Router');

// Open Routes
$api->version('v1', function ($api) {
	$api->post('oauth/access_token', 'App\Http\Controllers\Api\AuthController@login');
});

// Secured Routes with Oauth Header (Bearer)
$api->version('v1', ['middleware' => 'api.auth'], function ($api) {
    $api->resource('users', 'App\Http\Controllers\Api\UserController');
    $api->post('users/list', 'App\Http\Controllers\Api\UserController@index');

    // Image Utilities
    $api->get('images/{filename}', 'App\Http\Controllers\ImageController@show')->where('filename', '.*');
});
