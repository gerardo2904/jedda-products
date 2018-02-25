<?php

use Faker\Generator as Faker;
use App\Product;

$factory->define(Product::class, function (Faker $faker) {
    return [
        'name' => substr($faker->sentence(3), 0, -1),
        'description' => $faker->sentence(10),
        'long_description' => $faker->text,
        'id_unidad_prod' => 1,
        'cantidad_prod' => 1,
        'category_id' => $faker->numberBetween(1,5)
    ];
});
