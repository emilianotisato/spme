<?php

use App\Task;
use App\User;
use App\Status;
use App\Project;
use App\Priority;
use Faker\Generator as Faker;

$factory->define(Task::class, function (Faker $faker) {
    return [
        'user_id' => User::where('client_id', null)->inRandomOrder()->get()->pluck('id')->first(),
        'assigned_user' => User::where('client_id', null)->inRandomOrder()->get()->pluck('id')->first(),
        'project_id' => Project::inRandomOrder()->get()->pluck('id')->first(),
        'priority_id' => Priority::inRandomOrder()->get()->pluck('id')->first(),
        'status_id' => Status::inRandomOrder()->get()->pluck('id')->first(),
        'subject' => $faker->sentence,
        'description' => $faker->paragraph,
        'closed' => $faker->optional($weight = 0.1, $default = null)->dateTimeBetween($startDate = '-6 months', $endDate = 'now')
    ];
});
