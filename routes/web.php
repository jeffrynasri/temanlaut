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
$router->get('/key', function() {
    return str_random(32);
});
$router->group(['prefix' => 'api'], function () use ($router) {
  $router->get('dermagas',  ['uses' => 'DermagaController@showAllDermagas']);

  $router->get('dermagas/{id}', ['uses' => 'DermagaController@showOneDermaga']);

  $router->post('dermagas', ['uses' => 'DermagaController@create']);

  $router->delete('dermagas/{id}', ['uses' => 'DermagaController@delete']);

  $router->put('dermagas/{id}', ['uses' => 'DermagaController@update']);
});
