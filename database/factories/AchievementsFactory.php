<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Achievement;
use Faker\Generator as Faker;

$factory->define(Achievement::class, function (Faker $faker) {
    return [
        'name' => $faker->word,
        'description' => $faker->sentence,
        'icon' => 'default.svg'
    ];
});
