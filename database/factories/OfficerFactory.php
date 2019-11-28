<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Officer;
use Faker\Generator as Faker;

$factory->define(Officer::class, function (Faker $faker) {
    return [
        'user_id' => $faker->numberBetween(1, 100),
        'unit_number' => $faker->numberBetween(1, 99),
        'emergency_number' => $faker->numberBetween(1, 50),
        'vehicle_number' => $faker->numberBetween(1, 20),
        'zone' => $faker->randomLetter,
    ];
});
