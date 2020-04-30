<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Producto extends Model
{
    protected $table = 'productos';
    public $appends = ['base_price', 'kg_price', 'retail_price', 
                    'wholesale_price', 'resale_price'];

    public function marca(){
        return $this->belongsTo('App\Marca');
    }

    public function getBasePriceAttribute(){

        $discountValue = ($this->price * $this->discount_percent) / 100;

        return $this->price - $discountValue;
    }

    public function getKgPriceAttribute(){

        if($this->kilograms > 0){
            $baseKgPrice = $this->base_price / $this->kilograms;
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
