<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductosProveedoresTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('productos_proveedores', function (Blueprint $table) {
			$table->id();
			$table->bigInteger('producto_id')->unsigned()->nullable();
			$table->bigInteger('proveedor_id')->unsigned()->nullable();
			$table->float('price');
			$table->timestamps();
			
			$table->foreign('producto_id')->references('id')->on('productos');
			$table->foreign('proveedor_id')->references('id')->on('proveedores');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('productos_proveedores');
    }
}