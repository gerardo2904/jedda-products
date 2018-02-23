<?php

use Faker\Generator as Faker;

use App\CompanyImage;

$factory->define(CompanyImage::class, function (Faker $faker) {
    return [
        'image' => $faker->imageUrl(250,250),
        'company_id' => $faker->numberBetween(1,100)
    ];
});
