<?php

use Faker\Generator as Faker;

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| This directory should contain each of the model factory definitions for
| your application. Factories provide a convenient way to generate new
| model instances for testing / seeding your application's database.
|
*/

$factory->define(App\User::class, function (Faker $faker) {
    return [
        'avatar' => $faker->imageUrl(),
        'nick_name' => $faker->firstName . mt_rand(0, 100),
        'mobile' => $faker->randomElement(['136', '188', '159']) . mt_rand(1000, 9999) . mt_rand(1000, 9999),
        'password' => bcrypt('12346'),
        'credit1' => mt_rand(0, 10000),
        'credit2' => mt_rand(0, 10000),
        'credit3' => mt_rand(0, 10000),
        'is_active' => $faker->randomElement([\App\User::ACTIVE_NO, \App\User::ACTIVE_YES]),
        'is_lock' => $faker->randomElement([\App\User::LOCK_NO, \App\User::LOCK_YES]),
    ];
});
