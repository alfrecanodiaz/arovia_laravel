<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

use Illuminate\Routing\Router;
/** @var Router $router */

$router->get('/', function () {
    return view('home');
});

$router->group(['prefix' => '/mapa'/*, 'middleware' => ['first', 'second']*/], function (Router $router){

    /*===== Departamentos =====*/
    $router->get('departamentos/index', 'DepartamentosController@index')->name('mapa.departamentos.index');
    $router->post('departamentos/ajax-departamentos', 'DepartamentosController@indexAjax')->name('mapa.departamentos.ajax');
    $router->get('departamentos/create', 'DepartamentosController@create')->name('mapa.departamentos.create');
    $router->post('departamentos/store', 'DepartamentosController@store')->name('mapa.departamentos.store');
    $router->get('departamentos/edit/{id}', 'DepartamentosController@edit')->name('mapa.departamentos.edit');
    $router->post('departamentos/update/{id}', 'DepartamentosController@update')->name('mapa.departamentos.update');
    $router->delete('departamentos/delete/{id}', 'DepartamentosController@delete')->name('mapa.departamentos.delete');
    $router->get('departamentos/autocomplete', 'DepartamentosController@autocomplete')->name('mapa.departamentos.autocomplete');

    /*===== Distritos =====*/
    $router->get('distritos/index', 'DistritosController@index')->name('mapa.distritos.index');
    $router->post('distritos/ajax-departamentos', 'DistritosController@indexAjax')->name('mapa.distritos.ajax');
    $router->get('distritos/create', 'DistritosController@create')->name('mapa.distritos.create');
    $router->post('distritos/store', 'DistritosController@store')->name('mapa.distritos.store');
    $router->get('distritos/edit/{id}', 'DistritosController@edit')->name('mapa.distritos.edit');
    $router->post('distritos/update/{id}', 'DistritosController@update')->name('mapa.distritos.update');
    $router->delete('distritos/delete/{id}', 'DistritosController@delete')->name('mapa.distritos.delete');
    $router->get('distritos/autocomplete', 'DistritosController@autocomplete')->name('mapa.distritos.autocomplete');

});