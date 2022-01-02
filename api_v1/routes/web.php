<?php

/** @var \Laravel\Lumen\Routing\Router $router */

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It is a breeze. Simply tell Lumen the URIs it should respond to
| and give it the Closure to call when that URI is requested.
|
*/

$router->get('/', function () use ($router) {
    return $router->app->version();
});

//Without Auth Required
$router->group(['prefix' => 'auth/v1', 'namespace' => 'V1'], function ($router) {
	$router->post('/login', 'UserController@login');
	$router->post('/register', 'UserController@register');
	$router->post('/forgot-password', 'UserController@forgotPassword');
	$router->post('/reset-password', 'UserController@resetPassword');
	$router->post('/mpin-create', 'MpinController@mpinCreate');
	$router->post('/verify-otp', 'MpinController@verifyOTP');
	$router->post('/mpin-login', 'MpinController@mpinLogin');
	$router->post('/mpin-reset', 'MpinController@mpinReset');
	$router->get('/check-update', 'ForceUpdateController@verifyVersion');
});
