<?php

use App\Marca;
use App\Producto;
use App\Proveedor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});


Route::group(['prefix' => 'proveedores'], function () {
	Route::get('/', 'ProveedoresController@all')->name('proveedores.all');
	Route::post('/', 'ProveedoresController@create')->name('proveedores.create');
    Route::delete('/{id}', 'ProveedoresController@delete')->name('proveedores.delete');
    Route::get('/{id}', 'ProveedoresController@show')->name('proveedores.show');
    Route::post('/{id}', 'ProveedoresController@update')->name('proveedores.update');
});

Route::group(['prefix' => 'marcas'], function () {
	Route::get('/', 'MarcasController@all')->name('marcas.all');
	Route::post('/', 'MarcasController@create')->name('marcas.create');
	Route::delete('/{id}', 'MarcasController@delete')->name('marcas.delete');
	Route::get('/{id}', 'MarcasController@show')->name('marcas.show');
	Route::post('/{id}', 'MarcasController@update')->name('marcas.update');
});

Route::group(['prefix' => 'productos'], function () {
    Route::delete('/{id}', 'ProductosController@delete')->name('productos.delete');
	Route::post('/actualizar-precios', 'ProductosController@updatePrices')->name('productos.updatePrices');
	Route::post('/', 'ProductosController@create')->name('productos.create');
	Route::post('/{id}', 'ProductosController@update')->name('productos.update');
	Route::get('/{id}', 'ProductosController@show')->name('productos.show');
});

Route::group(['prefix' => 'datatables'], function () {
	Route::get('/proveedores', 'ProveedoresController@datatables')
			->name('datatables.proveedores');

	Route::get('/marcas', 'MarcasController@datatables')
			->name('datatables.marcas');

	Route::post('/productos', 'ProductosController@datatables')
			->name('datatables.productos');
});

Route::group(['prefix' => 'print'], function () {
	Route::post('/public-prices', 'PrintController@publicPrices')
		->name('print.publicPrices');
});