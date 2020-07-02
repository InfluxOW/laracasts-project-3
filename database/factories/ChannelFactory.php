<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Channel;
use Faker\Generator as Faker;

$factory->define(Channel::class, function (Faker $faker) {
    return [
        'name' => $faker->unique()->word(),
    ];
});

$factory->state(Channel::class, 'random', function () {
    return [
        'name' => 'Random',
    ];
});
