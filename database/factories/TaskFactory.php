<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Task;
use App\User;
use Faker\Generator as Faker;

$factory->define(Task::class, function (Faker $faker) {
    return [
        'name' => $faker->jobTitle,
        'description' => $faker->text(),
        'status' => 1,
        'price' => rand(20, 100),
        'creator_id' => User::query()->where('is_admin', 1)->first('id'),
        'created_at' => now(),
        'updated_at' => now(),
    ];
});
