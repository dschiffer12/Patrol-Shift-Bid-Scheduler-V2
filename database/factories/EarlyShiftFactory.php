<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Model;
use Faker\Generator as Faker;

$factory->define(App\Models\EarlyShift::class, function (Faker $faker) {
    return [
        'shift_id' => $faker->numberBetween(1, 3),
        'early_start_time' => $faker->time('H:i:s'),
        'early_end_time' => $faker->time('H:i:s'),
        'num_early_spot' => 3
    ];
});
