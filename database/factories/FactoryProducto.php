<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Producto;
use Faker\Generator as Faker;

$factory->define(Producto::class, function (Faker $faker) use ($factory){
    return [
		'name' => $faker->sentence(),
		'proveedor_id' => 1,
		'marca_id' => rand(1,3),
		'kg' => rand(1, 20),
		'price' => 1000,
		'units' => rand(1, 12)
    ];
});
