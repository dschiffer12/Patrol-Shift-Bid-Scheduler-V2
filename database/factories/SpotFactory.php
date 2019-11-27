<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Spot;
use Faker\Generator as Faker;

$factory->define(Spot::class, function (Faker $faker) {
    return [
        'shift_id' => $faker->numberBetween(1, 5),
        'qty_available' => $faker->numberBetween(1, 2),
    ];
});
