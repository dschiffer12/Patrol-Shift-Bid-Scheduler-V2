<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Model;
use App\Specialty;
use Faker\Generator as Faker;

$factory->define(Specialty::class, function (Faker $faker) {
    return [
        'name' => $faker->randomLetter
    ];
});
