<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Model;
use App\Models\Reviews;
use Faker\Generator as Faker;

$factory->define(Reviews::class, function (Faker $faker) {
    return [
        'salon_id'      => rand(1, 10),
        'customer_id'   => rand(1, 10),
        'employee_id'   => rand(1, 10),
        'rating_stars'  => rand(1, 5),
        'detail'        => $faker->realText($maxNbChars = 200, $indexSize = 2),
    ];
});
