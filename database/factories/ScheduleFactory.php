<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Schedule;
use Faker\Generator as Faker;

$factory->define(Schedule::class, function (Faker $faker) {
    return [
        'name' => $faker->name,
        'start_date' => $faker->date('Y-m-d'),
        'end_date' => $faker->date('Y-m-d'),
        'response_time' => $faker->numberBetween(1, 5),
        'currently_active' => $faker->numberBetween(0, 1),
        'template' => 0,
        'approved' => false,
    ];
});
