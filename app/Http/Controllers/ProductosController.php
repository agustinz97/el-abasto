<?php

namespace App\Http\Controllers;

use App\Marca;
use App\Producto;
use App\Proveedor;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class ProductosController extends Controller
{
    public function index(){
        return view('productos.index');
    }

    public function new(){
        return view('productos.new')->with([
			'marcas' => Marca::all(),
			'proveedores' => Proveedor::all(),
        ]);
    }

    public function delete($id){

        $product = Producto::findOrFail($id);

        $product->delete();

        return response()->json('deleted', 204);
        
    }

    public function create(Request $request){

        $validator = Validator::make($request->all(), [
            'kg' => 'nullable|numeric',
            'price' => 'required|numeric',
            'discount' => 'nullable|numeric',
			'marca' => 'nullable|numeric|exists:marcas,id',
            'name' => 'required|string|unique:productos,name,NULL,id,marca_id,'.$request->input('marca').',kg,'.$request->input('kg'),
            'proveedor' => '|numeric|exists:proveedores,id',
            'stock' => 'nullable|numeric'
		]);
		
		/* dd($request->input('marca')); */

        if($validator->fails()){
            return redirect()->back()->withErrors($validator)->withInput($request->all());
        }

        $producto = new Producto();
        $producto->name = $request->input('name');
        $producto->kg = $request->input('kg') ? $request->input('kg') : 0;
        $producto->stock = $request->input('stock') ? $request->input('stock') : 0;
        $producto->img_path = '';
		

        try{
			$producto->marca()->associate($request->input('marca'));
			$producto->save();
		
			$producto->proveedores()->attach($request->input('proveedor'), [
					'price' => $request->input('price'),
					'discount' => $request->input('discount') ? $request->input('discount') : 12,
				]);

			return redirect()->back()
							->with([
								'success' => 'Producto agregado correctamente'
							])
							->withInput($request->only(['marca', 'proveedor']));
        }catch(Exception $e){
            return redirect()->back()->with([
                'error' => 'Algo salió mal'
            ])->withInput($request->all());
        }

    }

    public function updatePrices(Request $request){
        
        $validator = Validator::make($request->all(), [
            'productos' => 'required|array',
            'productos.*' => 'integer',
            'percentage' => 'required|numeric'
        ]);

        if($validator->fails()){
            return response()->json($validator->errors(), 403);
        }

        $productos = Producto::findMany($request->input('productos'));

        try{
            foreach($productos as $prod){

                $increment = $prod->price * $request->input('percentage') / 100;

                $prod->price += $increment;
                $prod->update();
    
            }
        }catch(Exception $ex){
            return response()->json('Internal error', 500);
        }

	}
	
	public function show($id){
		$producto = Producto::findOrFail($id);

		dd($producto);
	}

	public function datatables(){
		$query = Producto::join('productos_proveedores', 'producto_id', '=', 'productos.id')
							->join('proveedores', 'proveedores.id', '=', 'proveedor_id')
							->select(['productos.id', 'productos.name', 
							'productos_proveedores.price as precio_factura', 
							'proveedores.name as proveedor', 'discount', 'productos.kg',
							'productos.marca_id as marca']);

        return datatables()
                ->eloquent($query)
                ->addColumn('btn', 'productos.actions')
				->rawColumns(['btn'])
				->editColumn('marca', function($model){

					$marca = Marca::find($model->marca);

					if($marca){
						return $marca->name;
					}else{
						return '-';
					}
				})
				->editColumn('discount', function($model){
					return $model->discount.'%';
				})
				->editColumn('flete', function(){
					return 55;
				})
                ->editColumn('format_name', function($product){

                    if($product->kg > 0){
                        return $product->name.' x'.$product->kg.'Kg';
                    }
                    return $product->name;
				})
				->editColumn('precio_compra', function($model){
					
					$desc = $model->precio_factura * $model->discount / 100;

					return $model->precio_factura - $desc + 55;

				})
                ->make(true);
	}

}
