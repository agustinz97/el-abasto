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
            'name' => 'required|string|unique:proveedores,name',
            'email' => 'nullable|string|unique:proveedores,email',
            'phone' => 'nullable|numeric|unique:proveedores,phone'
        ]);

        if($validator->fails()){
            return redirect()->back()->withErrors($validator)->withInput($request->all());
        }

        $proveedor = new Proveedor();

        $proveedor->name = $request->input('name');
        $proveedor->email = $request->input('email');
        $proveedor->phone = $request->input('phone');
        
        try{
            $proveedor->save();
            return redirect()->back()->with([
                'success' => 'Proveedor guardado con éxito'
            ]);
        }catch(Exception $ex){
            return redirect()->back()->with([
                'error' => 'Algo salió mal. Intente de nuevo mas tarde'
            ]);
        }

    }
}
