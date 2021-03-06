<?php

use Illuminate\Support\Facades\Route;

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

Route::get('/', 'ProductosController@public')->name('index');

Auth::routes();

Route::get('/dashboard', 'HomeController@index')->name('home');

Route::group(['middleware' => 'auth', 'prefix' => 'admin'], function () {
    Route::group(['prefix' => 'proveedores'], function () {
        Route::get('/', 'ProveedoresController@index')->name('proveedores.index');
        Route::get('/new', 'ProveedoresController@new')->name('proveedores.new');
    });

    Route::group(['prefix' => 'marcas'], function () {
        Route::get('/', 'MarcasController@index')->name('marcas.index');
        Route::get('/new', 'MarcasController@new')->name('marcas.new');
    });

    Route::group(['prefix' => 'productos'], function () {
        Route::get('/', 'ProductosController@index')->name('productos.index');
        Route::get('/new', 'ProductosController@new')->name('productos.new');
    });
});
