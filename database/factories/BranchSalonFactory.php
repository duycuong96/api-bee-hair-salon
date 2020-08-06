<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\BranchSalon;
use Faker\Generator as Faker;

$factory->define(BranchSalon::class, function (Faker $faker) {
    return [
        'name' => $faker->name,
        'thumb_img' => $faker->imageUrl($width = 400, $height = 200, 'business'),
        'content' => $faker->text($maxNbChars = 200),
        'work_time' => ['start' => "08:00", "end" => "21:00"],
        'address' => $faker->address,
        'locations' => [
            'lat' => 1,
            'long' => 2
        ],
    ];
});
