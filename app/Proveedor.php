<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Proveedor extends Model
{
	protected $table = 'proveedores';
	
	public function getNameAttribute($value){
		return ucfirst($value);
	}

    public function productos(){
        return $this->belongsToMany('App\Producto', 'productos_proveedores' )->withPivot('price');
    }
}
