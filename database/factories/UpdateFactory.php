<?php

use App\Update;
use Faker\Generator as Faker;

$factory->define(Update::class, function (Faker $faker) {
    return [
        'user_id' => \App\User::inRandomOrder()->get()->pluck('id')->first(),
        'description' => $faker->paragraph,
    ];
});
