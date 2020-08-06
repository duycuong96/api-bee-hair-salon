<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Model;
use App\Models\Service;
use Faker\Generator as Faker;

$factory->define(Service::class, function (Faker $faker) {
    return [
        'name'          => $faker->name,
        'slugs'         => $faker->name,
        'detail'        => $faker->realText($maxNbChars = 200, $indexSize = 2),
        'service_id'    => rand(1, 5),
        'images'        => [
            $faker->imageUrl($width = 400, $height = 200, 'fashion'),
            $faker->imageUrl($width = 400, $height = 200, 'fashion'),
        ],
        'price'         => 100,
        'sale_price'    => 80,
        'estimate'      => $faker->dateTimeThisCentury($max = 'now'),
    ];
});
