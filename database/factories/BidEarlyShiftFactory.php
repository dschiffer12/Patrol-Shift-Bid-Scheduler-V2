<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Model;
use App\Models\BidEarlyShift;
use Faker\Generator as Faker;

$factory->define(BidEarlyShift::class, function (Faker $faker) {
    return [
        'bid_id' => $faker->numberBetween(1, 100),
        'friday' => $faker->numberBetween(0, 1),
        'saturday' => $faker->numberBetween(0, 1),
        'sunday' => $faker->numberBetween(0, 1),
        'monday' => $faker->numberBetween(0, 1),
        'tuesday' => $faker->numberBetween(0, 1),
        'wednesday' => $faker->numberBetween(0, 1),
        'thursday' => $faker->numberBetween(0, 1),
    ];
});
