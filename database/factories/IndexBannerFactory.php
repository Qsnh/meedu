<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use Faker\Generator as Faker;

$factory->define(\App\Services\Other\Models\IndexBanner::class, function (Faker $faker) {
    return [
        'sort' => $faker->randomDigit,
        'name' => $faker->name,
        'course_ids' => '1,2',
    ];
});
