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
    $api->get('user/validate', 'App\Http\Controllers\Api\UserController@authorizeUser');
    $api->post('user/test', 'App\Http\Controllers\Api\UserController@hello');
    $api->get('user/list', 'App\Http\Controllers\Api\UserController@getList');

    // Image Utilities
    $api->get('images/{filename}', 'App\Http\Controllers\ImageController@show')->where('filename', '.*');
});
