<?php

namespace App\Http\Controllers;

use App\Marca;
use App\Proveedor;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Validator;

class MarcasController extends Controller
{
    public function index(){
        return view('marcas.index');
    }

    public function new(){
        return view('marcas.new')->with([
            'proveedores' => Proveedor::all()
        ]);
    }

    public function create(Request $request){

        $validator = Validator::make($request->all(), [
            'nombre' => 'required|string|unique:marcas,name',
        ]);

        if($validator->fails()){
			/* return redirect()->back()->withErrors($validator)->withInput($request->all()); */
			return response()->json($validator->errors(), 422);		
        }

        $marca = new Marca();
        $marca->name = $request->input('nombre');

        try{
            $marca->save();

			return response()->json($marca, 201);		
            
        }catch(Exception $ex){
            if (App::environment('local')) {
				return response()->json($ex->getMessage(), 500);
			}
			return response()->json('Something wrong', 500);
        }

    }

    public function delete($id){

        $marca = Marca::findOrFail($id);

        $marca->delete();

        return response()->json('deleted', 204);

	}
	
	public function datatables(){

		$query = Marca::query();

		return datatables()
                ->eloquent($query)
                ->addColumn('btn', 'marcas.actions')
                ->rawColumns(['btn'])
                ->toJson();
	}
}
