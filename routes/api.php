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
	Route::post('/', 'ProveedoresController@create')->name('proveedores.create');
    Route::delete('/{id}', 'ProveedoresController@delete')->name('proveedores.delete');
});

Route::group(['prefix' => 'marcas'], function () {
	Route::post('/', 'MarcasController@create')->name('marcas.create');
    Route::delete('/{id}', 'MarcasController@delete')->name('marcas.delete');
});

Route::group(['prefix' => 'productos'], function () {
    Route::delete('/{id}', 'ProductosController@delete')->name('productos.delete');
	Route::post('/actualizar-precios', 'ProductosController@updatePrices')->name('productos.updatePrices');
	Route::post('/', 'ProductosController@create')->name('productos.create');
	Route::post('/{id}', 'ProductosController@update')->name('productos.update');

});

Route::group(['prefix' => 'datatables'], function () {
	Route::get('/proveedores', 'ProveedoresController@datatables')
			->name('datatables.proveedores');

	Route::get('/marcas', 'MarcasController@datatables')
			->name('datatables.marcas');

	Route::get('/productos', 'ProductosController@datatables')
			->name('datatables.productos');
});