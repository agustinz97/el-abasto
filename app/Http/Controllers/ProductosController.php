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
			'precio' => 'required|numeric|min:1',
			'unidades' => 'nullable|numeric',
			'marca' => 'nullable|numeric|exists:marcas,id',
            'nombre' => 'required|string|unique:productos,name,NULL,id,marca_id,'.$request->input('marca').',kg,'.$request->input('kg'),
            'proveedor' => '|numeric|exists:proveedores,id',
            'stock' => 'nullable|numeric'
		]);
		
        if($validator->fails()){
			return response()->json($validator->errors(), 422);
        }

        $producto = new Producto();
        $producto->name = $request->input('nombre');
        $producto->kg = $request->input('kg') ?? 0;
        $producto->units = $request->input('unidades') ?? 0;
        $producto->stock = $request->input('stock') ?? 0;
        $producto->img_path = '';

        try{
			$producto->marca()->associate($request->input('marca'));
			$producto->save();
		
			$producto->proveedores()->attach($request->input('proveedor'), [
					'price' => $request->input('precio'),
				]);

			return response()->json($producto, 201);

        }catch(Exception $ex){
            if (App::environment('local')) {
				return response()->json($ex->getMessage(), 500);
			}
			return response()->json('Something wrong', 500);
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
							->select(['productos.id', 'productos.name', 'proveedores.id as proveedor_id', 
							'productos_proveedores.price as precio_factura', 
							'proveedores.name as proveedor', 'proveedores.discount_percent as discount',
							'productos.kg', 'productos.marca_id as marca', 
							'proveedores.shipping as flete', 'productos.units']);

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
				->editColumn('base_price', function($product){
					return $product->basePriceProveedor($product->proveedor_id);
				})
                ->make(true);
	}

}
