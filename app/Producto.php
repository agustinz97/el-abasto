<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Producto extends Model
{
    protected $table = 'productos';
    public $appends = ['base_price','kg_price', 'retail_price', 'unit_price',
					'wholesale_price', 'resale_price', 'format_name'];

    public function marca(){
        return $this->belongsTo('App\Marca');
	}
	
	public function proveedor(){
		return $this->belongsTo('App\Proveedor');
	}

	public function getNameAttribute($value){
		return ucfirst($value);
	}

	public function getFormatNameAttribute(){
		$name = $this->name;
		if($this->kg >= 1){
			$name.=' x'.$this->kg.'Kg';
		}elseif($this->kg > 0){
			$name.=' x'.($this->kg*1000).'g';
		}
		return $name;
	}

	public function getUnitPriceAttribute(){
		return $this->price / $this->units;
	}

    public function getBasePriceAttribute(){
		
		$discount = $this->price * $this->proveedor->discount_percent /100;
		
		$basePrice = $this->price - $discount + $this->proveedor->shipping;

		return $basePrice / $this->units;
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

        $profit = $this->base_price * 30 / 100;

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
