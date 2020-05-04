<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Producto extends Model
{
    protected $table = 'productos';
    public $appends = ['base_price', 'kg_price', 'retail_price', 
					'wholesale_price', 'resale_price'];
	private $SHIPPING_COST = 55;

    public function marca(){
        return $this->belongsTo('App\Marca');
	}
	
	public function proveedores(){
		return $this->belongsToMany('App\Proveedor', 'productos_proveedores')->withPivot('price');
	}

    public function getBasePriceAttribute(){
		$prov = $this
					->proveedores()
					->orderBy('price', 'desc')	
					->first();

		if(!isset($prov)){
			return 0;
		}

		$price = $prov->pivot->price;

        $discountValue = ($price * $this->discount_percent) / 100;

        return $price - $discountValue + $this->SHIPPING_COST;
    }

    public function getKgPriceAttribute(){

        if($this->kg > 0){
            $baseKgPrice = $this->base_price / $this->kg;
            $profit = ($baseKgPrice * 40) / 100;

            return $baseKgPrice + $profit;
        }

        return null;
    }

    public function getRetailPriceAttribute(){

        $profit = $this->basePrice * 30 / 100;

        return $this->base_price + $profit;
    }

    public function getWholesalePriceAttribute(){

        $profit = $this->basePrice * 20 / 100;

        return $this->base_price + $profit;
    }

    
    public function getResalePriceAttribute(){

        $profit = $this->basePrice * 25 / 100;

        return $this->base_price + $profit;
    }

}
