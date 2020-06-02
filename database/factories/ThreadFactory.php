<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Thread;
use App\User;
use Faker\Generator as Faker;

$factory->define(Thread::class, function (Faker $faker) {
    return [
        'title' => $faker->sentence(),
        'body' => $faker->paragraph()
    ];
});

$factory->afterMaking(Thread::class, function ($thread) {
    $thread->user()->associate(User::all()->random());
});
