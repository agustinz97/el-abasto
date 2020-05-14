<?php

namespace App\Http\Controllers;

use App\Producto;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use \PDF;

class PrintController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */	
    public function publicPrices(Request $request)
    {
		$products = null;
		$path = '/pdf/precios.pdf';

		if($request->input('ids')){
			$products = Producto::with(['marca', 'proveedor'])
							->whereIn('id', $request->input('ids'))
							->orderBy('marca_id', 'desc')
							->get();
		}else{
			$products = Producto::with(['marca', 'proveedor'])->orderBy('marca_id', 'desc')->get();
		}
	
		try{
			$pdf = App::make('dompdf.wrapper');
			$pdf->getDomPDF()->set_option("enable_php", true);
			$pdf->loadView('print.public-prices', [
				'products' => $products,
			])->save(public_path($path));
				
			return response()->json(asset($path), 200, ['Content-Type'=> 'application/pdf']);
		}catch(Exception $ex){
			if(App::environment('local')){
				return response()->json($ex->getMessage(), 500);
			}else{
				return response()->json('Algo salió mal', 500);
			}
		}
		
    }
}
