<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Marca extends Model
{
	protected $table = 'marcas';
	
	public function getNameAttribute($value){
		return ucfirst($value);
	}

    public function productos(){
        return $this->hasMany('App\Producto');
    }
}
