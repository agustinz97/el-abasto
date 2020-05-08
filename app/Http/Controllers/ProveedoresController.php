<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Proveedor;
use Exception;
use Illuminate\Log\Logger;
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

        return response('', 204);

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
			/* return redirect()->back()->withErrors($validator)->withInput($request->all()); */
			return response()->json($validator->errors(), 422 );
        }

        $proveedor = new Proveedor();

        $proveedor->name = $request->input('nombre');
        $proveedor->email = $request->input('email');
        $proveedor->phone = $request->input('telefono');
        $proveedor->discount_percent = $request->input('descuento');
        $proveedor->shipping = $request->input('flete');
        
        try{
            $proveedor->save();
            /* return redirect()->back()->with([
                'success' => 'Proveedor guardado con éxito'
			]); */
			
			return response()->json($proveedor, 201);

        }catch(Exception $ex){
            /* return redirect()->back()->with([
                'error' => 'Algo salió mal. Intente de nuevo mas tarde'
			]); */
			
			if (App::environment('local')) {
				return response()->json($ex->getMessage(), 500);
			}
			return response()->json('Something wrong', 500);
        }

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
