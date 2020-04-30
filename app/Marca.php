<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Marca extends Model
{
    protected $table = 'marcas';

    public function proveedor(){
        return $this->belongsTo('App\Proveedor');
    }

    public function productos(){
        return $this->hasMany('App\Producto');
    }
}
