<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Model;
use App\Models\BiddingQueue;
use Faker\Generator as Faker;

$factory->define(BiddingQueue::class, function (Faker $faker) {
    return [
        'user_id' => $faker->numberBetween(1, 5),
        'schedule_id' => $faker->numberBetween(1, 5),
        'bidding_spot' => $faker->numberBetween(1, 5),
        'waiting_to_bid' => false,
        'bidding' => true,
        'bid_submitted' => false,
    ];
});
