<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('productos', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('img_path')->nullable();
			$table->float('stock')->default(0);
			$table->integer('kg')->default(0);
            $table->bigInteger('marca_id')->unsigned()->nullable();
            $table->timestamps();

			$table->foreign('marca_id')->references('id')->on('marcas');
			$table->unique(['name', 'marca_id', 'kg']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('productos');
    }
}
