<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Model;
use Faker\Generator as Faker;

$factory->define(App\Models\BiddingSchedule::class, function (Faker $faker) {
    return [
        'name' => $faker->name,
        'start_day' => $faker->date('Y-m-d'),
        'end_day' => $faker->date('Y-m-d'),
        'response_time' => $faker->numberBetween(1, 5),
        'currently_active' => $faker->boolean,
        'save_as_template' => $faker->boolean
    ];
});
