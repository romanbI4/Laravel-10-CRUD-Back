<?php

/** @var Router $router */

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all the routes for an application.
| It is a breeze. Simply tell Lumen the URIs it should respond to
| and give it the Closure to call when that URI is requested.
|
*/

use App\Http\Middleware\UserValidationMiddleware;
use Illuminate\Support\Facades\Route;
use Laravel\Lumen\Routing\Router;

$router->get('/', function () use ($router) {
    return $router->app->version();
});

$router->group(['prefix' => 'api/user'], function ($app) {
    $app->group(['middleware' => UserValidationMiddleware::class], function ($app) {
        $app->post('/register', 'UsersController@register');
        $app->post('/sign-in', 'UsersController@signIn');
    });

    Route::post('/recover-password/link', 'UsersController@postLink');
    Route::post('/recover-password/submit', ['as' => 'password.reset', 'uses' => 'UsersController@postPassword']);

    $app->group(['middleware' => 'auth'], function ($app) {
        $app->post('/companies', 'CompaniesController@store');
        $app->get('/companies', 'CompaniesController@index');
        $app->get('/companies/{id}', 'CompaniesController@show');
        $app->put('/companies/{id}', 'CompaniesController@update');
        $app->delete('/companies/{id}', 'CompaniesController@destroy');
    });
});


