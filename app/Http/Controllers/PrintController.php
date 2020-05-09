<?php

namespace App\Http\Controllers;

use App\Producto;
use Illuminate\Http\Request;
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

		$products = Producto::with(['marca', 'proveedores'])->get();

		$pdf = PDF::loadView('print.public-prices', [
			'products' => $products,
			'filterBy' => 'todos'
		]);
  
        return $pdf->stream('itsolutionstuff.pdf');
    }
}
