<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Model;
use Faker\Generator as Faker;

$factory->define(App\Models\Shift::class, function (Faker $faker) {
    return [
        'name' => $faker->name,
        'start_time' => $faker->time('H:i:s'),
        'end_time' => $faker->time('H:i:s'),
        'minimun_staff' => 5
    ];
});
