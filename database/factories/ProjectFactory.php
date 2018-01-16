<?php

use App\Project;
use Faker\Generator as Faker;

$factory->define(Project::class, function (Faker $faker) {
    return [
        'client_id' => \App\Client::inRandomOrder()->get()->pluck('id')->first(),
        'name' => $faker->sentence,
        'website' => $faker->domainName,
        'notes' => $faker->paragraph
    ];
});
