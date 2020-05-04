<?php

namespace App\Http\Controllers;

use App\Marca;
use App\Producto;
use App\Proveedor;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ProductosController extends Controller
{
    public function index(){
        return view('productos.index');
    }

    public function new(){
        return view('productos.new')->with([
			'marcas' => Marca::all(),
			'proveedores' => Proveedor::all()
        ]);
    }

    public function delete($id){

        $product = Producto::findOrFail($id);

        $product->delete();

        return response()->json('deleted', 204);
        
    }

    public function create(Request $request){

        $validator = Validator::make($request->all(), [
            'name' => 'required|string',
            'kg' => 'nullable|numeric',
            'price' => 'required|numeric',
            'discount' => 'nullable|numeric',
            'marca' => 'required|numeric|exists:marcas,id',
            'stock' => 'nullable|numeric'
        ]);

        if($validator->fails()){
            return redirect()->back()->withErrors($validator)->withInput($request->all());
        }

        $producto = new Producto();
        $producto->name = $request->input('name');
        $producto->kilograms = $request->input('kg');
        $producto->price = $request->input('price');
        $producto->discount_percent = $request->input('discount');
        $producto->stock = $request->input('stock');
        $producto->img_path = '';
        $producto->marca()->associate($request->input('marca'));

        try{
            $producto->save();

            return redirect()->back()->with([
                'success' => 'Producto agregado correctamente'
            ]);
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

}
