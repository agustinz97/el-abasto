<?php

namespace App\Http\Controllers;

use App\Marca;
use App\Producto;
use App\Proveedor;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class ProductosController extends Controller
{
    public function index(){
        return view('productos.index')->with([
			'proveedores' => Proveedor::all(),
			'marcas' => Marca::all()
		]);
	}
	
	public function public(){
        return view('productos.public')->with([
			'marcas' => Marca::all()
		]);
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
			'nombre' => 'required|string|unique:productos,name,NULL,id,marca_id,'
				.$request->input('marca').',kg,'.$request->input('kg').',proveedor_id,'.$request->input('proveedor'),
            'proveedor' => '|numeric|exists:proveedores,id',
            'stock' => 'nullable|numeric'
		]);
		
        if($validator->fails()){
			return response()->json($validator->errors(), 422);
        }

        $producto = new Producto();
        $producto->name = $request->input('nombre');
        $producto->kg = $request->input('kg') ?? 0;
        $producto->units = $request->input('unidades') ?? 1;
        $producto->stock = $request->input('stock') ?? 0;
        $producto->price = $request->input('precio');
        $producto->img_path = '';

        try{
			$producto->marca()->associate($request->input('marca'));
			$producto->proveedor()->associate($request->input('proveedor'));
			$producto->save();
		
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
            return response()->json($validator->errors(), 422);
        }

        $productos = Producto::findMany($request->input('productos'));

        try{
            foreach($productos as $prod){

                $increment = $prod->price * $request->input('percentage') / 100;

                $prod->price += $increment;
                $prod->save();
    
            }
        }catch(Exception $ex){
            return response()->json('Internal error', 500);
        }

	}
	
	public function show($id){
		
		try{
			$producto = Producto::with(['marca', 'proveedor'])->find($id);

			if($producto){
				return response()->json($producto, 200);
			}else{
				return response()->json('No se encontró el producto', 404);
			}
		}catch(Exception $ex){
			if(App::environment('local')){
				return response()->json($ex->getMessage(), 500);
			}else{
				return response()->json('Algo salió mal.', 500);

			}
		}

	}

	public function update(Request $request, $id){

		$validator = Validator::make($request->all(), [
            'kg' => 'nullable|numeric',
			'precio' => 'required|numeric|min:1',
			'unidades' => 'nullable|numeric',
			'marca' => 'nullable|numeric|exists:marcas,id',
			'nombre' => 'required|string|unique:productos,name,'.$id.',id,marca_id,'
				.$request->input('marca').',kg,'.$request->input('kg').',proveedor_id,'.$request->input('proveedor'),
            'proveedor' => '|numeric|exists:proveedores,id',
            'stock' => 'nullable|numeric'
		]);
		
        if($validator->fails()){
			return response()->json($validator->errors(), 422);
		}
		
		$producto = Producto::find($id);

		if(!$producto){
			return response()->json('Producto no encontrado', 404);
		}

        $producto->name = $request->input('nombre');
        $producto->kg = $request->input('kg') ?? 0;
        $producto->units = $request->input('unidades') ?? 1;
        $producto->stock = $request->input('stock') ?? 0;
        $producto->price = $request->input('precio');
        $producto->img_path = '';

		try{
			$producto->marca()->associate($request->input('marca'));
			$producto->proveedor()->associate($request->input('proveedor'));
			$producto->save();
		
			return response()->json($producto, 201);

        }catch(Exception $ex){
            if (App::environment('local')) {
				return response()->json($ex->getMessage(), 500);
			}
			return response()->json('Something wrong', 500);
        }
	}

	public function datatables(Request $request){

		$marca = $request->marca;
		$proveedor = $request->proveedor;

		$productos = Producto::query()
					->when($marca, function ($query, $marca){
						return $query->where('marca_id', '=', $marca);
					})
					->when($proveedor, function ($query, $proveedor){
						return $query->where('proveedor_id', '=', $proveedor);
					})
					->with('marca', 'proveedor');

        return datatables()
                ->eloquent($productos)
                ->addColumn('btn', 'productos.actions')
				->rawColumns(['btn'])
                ->make();
	}

}
