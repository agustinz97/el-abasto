<?php

namespace App\Http\Controllers;

use App\Marca;
use App\Proveedor;
use Exception;
use Illuminate\Http\Request;
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
            'name' => 'required|string|unique:marcas,name',
        ]);

        if($validator->fails()){
            return redirect()->back()->withErrors($validator)->withInput($request->all());
        }

        $marca = new Marca();
        $marca->name = $request->input('name');

        try{
            $marca->save();

            return redirect()->back()->with([
                'success' => 'Marca creada exitosamente'
            ]);
        }catch(Exception $ex){
            return redirect()->back()->with([
                'error' => $ex->getMessage()
            ]);
        }

    }

    public function delete($id){

        $marca = Marca::findOrFail($id);

        $marca->delete();

        return response()->json('deleted', 204);

    }
}
