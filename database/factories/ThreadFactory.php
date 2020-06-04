<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Channel;
use App\Thread;
use App\User;
use Faker\Generator as Faker;

$factory->define(Thread::class, function (Faker $faker) {
    return [
        'channel_id' => factory(Channel::class),
        'user_id' => factory(User::class),
        'title' => $faker->sentence(),
        'body' => $faker->paragraph()
    ];
});
