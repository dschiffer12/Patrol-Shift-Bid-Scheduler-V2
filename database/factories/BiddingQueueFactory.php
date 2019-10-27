<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Model;
use App\Models\BiddingQueue;
use Faker\Generator as Faker;

$factory->define(BiddingQueue::class, function (Faker $faker) {
    return [
        'bidding_spot' => $faker->numberBetween(1, 100),
        'waiting_to_bid' => $faker->boolean,
        'bidding' => $faker->boolean,
        'bid_submitted' => $faker->boolean,
        'start_time_bidding' => $faker->date('Y-m-d'),
        'end_time_bidding' => $faker->date('Y-m-d'),
    ];
});
