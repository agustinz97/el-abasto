<?php

use App\Marca;
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
    Route::delete('/{id}', 'ProveedoresController@delete')->name('proveedores.delete');
});

Route::group(['prefix' => 'marcas'], function () {
    Route::delete('/{id}', 'MarcasController@delete')->name('marcas.delete');
});

Route::group(['prefix' => 'productos'], function () {
    Route::delete('/{id}', 'ProductosController@delete')->name('productos.delete');
    Route::post('/actualizar-precios', 'ProductosController@updatePrices')->name('productos.updatePrices');
});

Route::group(['prefix' => 'datatables'], function () {
    Route::get('/proveedores', function () {
        return datatables()
                ->eloquent(App\Proveedor::query())
                ->addColumn('btn', 'proveedores.actions')
                ->rawColumns(['btn'])
                ->toJson();
    })->name('datatables.proveedores');

    Route::get('/marcas', function () {
        return datatables()
                ->eloquent(App\Marca::query()->with('proveedor'))
                ->addColumn('btn', 'marcas.actions')
                ->rawColumns(['btn'])
                ->toJson();
    })->name('datatables.marcas');

    Route::get('/productos', function () {
        return datatables()
                ->eloquent(App\Producto::query()->with('marca'))
                ->addColumn('btn', 'productos.actions')
                ->rawColumns(['btn'])
                ->editColumn('marca.proveedor_id', function ($product){
                    $proveedor = Proveedor::find($product->marca->proveedor_id);

                    if(isset($proveedor)){
                        return $proveedor->name;
                    }else{
                        return '-';
                    }
                })
                ->editColumn('format_name', function($product){

                    if($product->kilograms > 0){
                        return $product->name.' x'.$product->kilograms.'Kg';
                    }
                    return $product->name;
                })
                ->toJson();
    })->name('datatables.productos');
});