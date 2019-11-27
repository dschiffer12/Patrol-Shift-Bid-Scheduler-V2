<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Shift;
use Faker\Generator as Faker;

$factory->define(Shift::class, function (Faker $faker) {
    return [
        'schedule_id' => $faker->numberBetween(1, 5),
        'specialty_id' => $faker->numberBetween(1, 5),
    ];
});
