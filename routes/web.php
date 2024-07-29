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

// $router->group(['prefix' => 'api/v1/testing'], function() use ($router){
//     $router->get('/', ['uses' => 'UserController@index']);
// 	$router->post('/', ['uses' => 'UserController@create ']);
// 	$router->get('/{id}', ['uses' => 'UserController@show']);
// 	$router->delete('/{id}', ['uses' => 'UserController@destroy']);
// 	$router->put('/{id}', ['uses' => 'UserController@update']);
// });

$router->group(['prefix' => 'api/v1/user','middleware' => 'auth'], function() use ($router){
    $router->get('/', ['uses' => 'UserController@index']);
});

$router->group(['prefix' => 'api/v1/order','middleware' => 'auth'], function() use ($router){
    $router->get('/', ['uses' => 'OrderController@index']);
    $router->post('/add', ['uses' => 'OrderController@store']);
    $router->get('/{id}', ['uses' => 'OrderController@show']);
    $router->put('/{id}', ['uses' => 'OrderController@update']);
    $router->delete('/{id}', ['uses' => 'OrderController@destroy']);
});

$router->group(['prefix' => 'api/v1/orderitem','middleware' => 'auth'], function() use ($router){
    $router->get('/', ['uses' => 'OrderitemController@index']);
    $router->post('/add', ['uses' => 'OrderitemController@store']);
    $router->get('/{id}', ['uses' => 'OrderitemController@show']);
    $router->put('/{id}', ['uses' => 'OrderitemController@update']);
    $router->delete('/{id}', ['uses' => 'OrderitemController@destroy']);
});

$router->group(['prefix' => 'api/v1/product','middleware' => 'auth'], function() use ($router){
    $router->get('/', ['uses' => 'ProductController@index']);
    $router->post('/add', ['uses' => 'ProductController@store']);
    $router->get('/{id}', ['uses' => 'ProductController@show']);
    $router->delete('/{id}', ['uses' => 'ProductController@destroy']);
    $router->put('/{id}', ['uses' => 'ProductController@update']);
});

$router->group(['prefix' => 'api/v1/meja','middleware' => 'auth'], function() use ($router){
    $router->get('/', ['uses' => 'MejaController@index']);
    $router->post('/add', ['uses' => 'MejaController@store']);
    $router->get('/{id}', ['uses' => 'MejaController@show']);
    $router->delete('/{id}', ['uses' => 'MejaController@destroy']);
    $router->put('/{id}', ['uses' => 'MejaController@update']);
});

$router->group(['prefix' => 'api/v1/customer','middleware' => 'auth'], function() use ($router){
    $router->get('/', ['uses' => 'CustomerController@index']);
    $router->post('/add', ['uses' => 'CustomerController@store']);
    $router->get('/{id}', ['uses' => 'CustomerController@show']);
    $router->delete('/{id}', ['uses' => 'CustomerController@destroy']);
    $router->put('/{id}', ['uses' => 'CustomerController@update']);
});

$router->group(['prefix' => 'api/v1/booking','middleware' => 'auth'], function() use ($router){
    $router->get('/', ['uses' => 'BookingController@index']);
    $router->post('/add', ['uses' => 'BookingController@store']);
    $router->get('/{id}', ['uses' => 'BookingController@show']);
    $router->delete('/{id}', ['uses' => 'BookingController@destroy']);
    $router->put('/{id}', ['uses' => 'BookingController@update']);
});