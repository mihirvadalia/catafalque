<?php

use Illuminate\Http\Request;

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

$api->version('v1', function ($api) {
	$api->post('oauth/access_token', function() {
		return Authorizer::issueAccessToken();
	});
});

$api->version('v1', ['middleware' => 'api.auth'], function ($api) {
    $api->get('user/validate', 'App\Http\Controllers\UserController@authorizeUser');
    $api->get('user/test', 'App\Http\Controllers\UserController@hello');
});
