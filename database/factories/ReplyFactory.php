<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Reply;
use App\Thread;
use App\User;
use Faker\Generator as Faker;

$factory->define(Reply::class, function (Faker $faker) {
    return [
        'body' => $faker->paragraph(),
        'thread_id' => factory(Thread::class),
        'user_id' => factory(User::class),
    ];
});

$factory->afterMaking(Reply::class, function ($reply) {
    $reply->user()->associate(User::all()->random());
    $reply->thread()->associate(Thread::all()->random());
});
