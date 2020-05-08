<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Producto extends Model
{
    protected $table = 'productos';
    public $appends = ['base_price','kg_price', 'retail_price', 
					'wholesale_price', 'resale_price', 'format_name'];

    public function marca(){
        return $this->belongsTo('App\Marca');
	}
	
	public function proveedores(){
		return $this->belongsToMany('App\Proveedor', 'productos_proveedores')->withPivot('price');
	}

	public function getNameAttribute($value){
		return ucfirst($value);
	}

	public function getFormatNameAttribute(){
		$name = $this->name;
		if($this->units > 0){
			$name.=' '.$this->units.'u.';
		}
		if($this->kg >= 1){
			$name.=' x'.$this->kg.'Kg';
		}elseif($this->kg > 0){
			$name.=' x'.($this->kg).'g';
		}
		return $name;
	}

    public function getBasePriceAttribute(){
		$prov = $this
					->proveedores()
					->orderBy('price', 'desc')	
					->first();

		if(isset($prov)){

			return $this->basePriceProveedor($prov->id);
		}
		
		return 0;
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

	public function basePriceProveedor($proveedor_id = 0){

		$proveedor = $this->proveedores()->wherePivot('proveedor_id', '=', $proveedor_id)->first();

		if($proveedor){

			$price = $proveedor->pivot->price;
			$discount_percent = $proveedor->discount_percent;
			$shipping = $proveedor->shipping;

			$discount = $price * $discount_percent / 100;

			return $price - $discount + $shipping;
		}

		return 0;
	}
}
