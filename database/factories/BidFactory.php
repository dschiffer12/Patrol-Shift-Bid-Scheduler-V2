<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Model;
use App\Models\Bid;
use Faker\Generator as Faker;

$factory->define(Bid::class, function (Faker $faker) {
    return [
        'user_id' => $faker->numberBetween(1, 100),
        'bidding_schedule_id' => $faker->numberBetween(1, 100),
        'shift_id' => $faker->numberBetween(0, 100),
        'friday' => $faker->numberBetween(0, 1),
        'saturday' => $faker->numberBetween(0, 1),
        'sunday' => $faker->numberBetween(0, 1),
        'monday' => $faker->numberBetween(0, 1),
        'tuesday' => $faker->numberBetween(0, 1),
        'wednesday' => $faker->numberBetween(0, 1),
        'thursday' => $faker->numberBetween(0, 1),

    ];
});
