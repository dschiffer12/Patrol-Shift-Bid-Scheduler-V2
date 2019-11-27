<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Model;
use App\Models\Bid;
use Faker\Generator as Faker;

$factory->define(Bid::class, function (Faker $faker) {
    return [
        'user_id' => $faker->numberBetween(1, 100),
        'spot_id' => $faker->numberBetween(1, 100),
        'approved' => false,
        'bidding_queue_id' => $faker->numberBetween(0, 1),
    ];
});
