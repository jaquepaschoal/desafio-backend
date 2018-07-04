<?php

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

$router->group(['prefix' => 'tickets'], function ($router)
{
    $router->post('/priority', 'TicketsController@priority');
});

$router->group(['prefix' => 'orderby'], function ($router)
{
    $router->put('/date/{type}', 'ActionsController@orderbyDate');
    $router->put('/priority', 'ActionsController@orderbyPriority');
});

$router->group(['prefix' => 'filter'], function ($router)
{
    $router->put('/date/{initial}/{final}', 'ActionsController@filterbyDate');
    $router->put('/priority/{type}', 'ActionsController@filterbyPriority');
});

$router->group(['prefix' => 'pagination'], function ($router)
{
    $router->put('/{items}/{number}', 'ActionsController@pagination');
});



