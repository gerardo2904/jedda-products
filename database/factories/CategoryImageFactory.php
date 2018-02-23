<?php

use Faker\Generator as Faker;
use App\CategoryImage;

$factory->define(CategoryImage::class, function (Faker $faker) {
    return [
        'image' => $faker->imageUrl(250,250),
        'category_id' => $faker->numberBetween(1,100)
    ];
});
