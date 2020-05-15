<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Proveedor;
use Exception;
use Illuminate\Log\Logger;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Validator;

class ProveedoresController extends Controller
{
    /*Show view with the resources */
    public function index()
    {
        return view('proveedores.index');
    }

    /*Show view to create a new resource */
    public function new(){
        return view('proveedores.new');
    }

    /*Deletes the specified resource */
    public function delete($id){
        
        $proveedor = Proveedor::findOrFail($id);

        $proveedor->delete();

        return response('deleted', 204);

	}
	
	public function show($id){

		$proveedor = Proveedor::find($id);
		
		if($proveedor){
			return response()->json($proveedor, 200);
		}else{
			return response()->json('Not found', 404);
		}
	}

    /*Creates a new resource */
    public function create(Request $request){

        $validator = Validator::make($request->all(),[
            'nombre' => 'required|string|unique:proveedores,name',
            'email' => 'nullable|string|unique:proveedores,email',
			'telefono' => 'nullable|numeric|unique:proveedores,phone|digits_between:6,10',
			'descuento' => 'nullable|numeric',
			'flete' => 'nullable|numeric'
        ]);

        if($validator->fails()){
			return response()->json($validator->errors(), 422 );
        }

        $proveedor = new Proveedor();

        $proveedor->name = $request->input('nombre');
        $proveedor->email = $request->input('email');
        $proveedor->phone = $request->input('telefono');
        $proveedor->discount_percent = $request->input('descuento') ?? 0;
        $proveedor->shipping = $request->input('flete') ?? 0;
        
        try{
            $proveedor->save();
			
			return response()->json($proveedor, 201);

        }catch(Exception $ex){
			
			if (App::environment('local')) {
				return response()->json($ex->getMessage(), 500);
			}
			return response()->json('Something wrong', 500);
        }

	}

	public function update(Request $request, $id){

		$proveedor = Proveedor::find($id);

		if($proveedor){
			$validator = Validator::make($request->all(),[
				'nombre' => 'required|string|unique:proveedores,name,'.$id,
				'email' => 'nullable|string|unique:proveedores,email,'.$id,
				'telefono' => 'nullable|numeric|unique:proveedores,phone|digits_between:6,10',
				'descuento' => 'nullable|numeric',
				'flete' => 'nullable|numeric'
			]);

			if(!$validator->fails()){

				$proveedor->name = $request->input('nombre');
				$proveedor->email = $request->input('email');
				$proveedor->phone = $request->input('telefono');
				$proveedor->discount_percent = $request->input('descuento') ?? 0;
				$proveedor->shipping = $request->input('flete') ?? 0;

				try{
					$proveedor->save();

					return response()->json($proveedor, 200);
				}catch(Exception $ex){
					
					if (App::environment('local')) {
						return response()->json($ex->getMessage(), 500);
					}
					return response()->json('Something wrong.', 500);
				}

			}

			return response()->json($validator->errors(), 422 );

		}

		return response()->json('Not found', 404);
	}
	
	public function datatables(){

		$query = Proveedor::query();
		
		return datatables()
                ->eloquent($query)
                ->addColumn('btn', 'proveedores.actions')
                ->rawColumns(['btn'])
                ->toJson();
	}
}
