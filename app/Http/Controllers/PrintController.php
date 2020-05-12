<?php

namespace App\Http\Controllers;

use App\Producto;
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
    public function publicPrices()
    {

		$products = Producto::with(['marca', 'proveedor'])->orderBy('marca_id', 'desc')->get();


		$pdf = App::make('dompdf.wrapper');
		$pdf->loadView('print.public-prices', [
			'products' => $products,
			'filterBy' => 'todos'
		]);
		$pdf->getDomPDF()->set_option("enable_php", true);
  
        return $pdf->stream('itsolutionstuff.pdf');
    }
}
