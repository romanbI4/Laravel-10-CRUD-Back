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

$router->group(['prefix' => 'api/user/'], function ($app) {

    $app->post('register/','UsersController@register');
    $app->post('sign-in/','UsersController@signIn');
    $app->post('recover-password/','UsersController@recoverPassword');

    $app->group(['middleware' => 'middleware.auth'], function ($app) {
        $app->post('companies/','CompaniesController@store');
        $app->get('companies/', 'CompaniesController@index');
        $app->get('companies/{id}/', 'CompaniesController@show');
        $app->put('companies/{id}/', 'CompaniesController@update');
        $app->delete('companies/{id}/', 'CompaniesController@destroy');
    });

});


