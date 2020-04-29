<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Producto extends Model
{
    protected $table = 'productos';
    public $appends = ['base_price', 'kg_price', 'retail_price', 'wholesale_price', 'resale_price'];

    public function marca(){
        return $this->belongsTo('App\Marca');
    }

    public function getBasePriceAttribute(){

        $discountValue = ($this->price * $this->discount_percent) / 100;

        return $this->price - $discountValue;
    }

    public function getKgPriceAttribute(){

        $baseKgPrice = $this->base_price / $this->kilograms;
        $kgPrice = ($baseKgPrice * 40) / 100;

        return $kgPrice;
    }

    public function getRetailPriceAttribute(){

        $retailPrice = $this->basePrice * 30 / 100;

        return $retailPrice;
    }

    public function getWholesalePriceAttribute(){

        $price = $this->basePrice * 20 / 100;

        return $price;
    }

    
    public function getResalePriceAttribute(){

        $price = $this->basePrice * 25 / 100;

        return $price;
    }
}
