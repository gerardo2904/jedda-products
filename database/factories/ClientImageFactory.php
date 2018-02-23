<?php

use Faker\Generator as Faker;
use App\ClientImage;

$factory->define(ClientImage::class, function (Faker $faker) {
    return [
        'image' => $faker->imageUrl(250,250),
        'client_id' => $faker->numberBetween(1,100)
    ];
});