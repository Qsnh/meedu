<?php

use Faker\Generator as Faker;

$factory->define(\App\Services\Course\Models\CourseCategory::class, function (Faker $faker) {
    return [
        'name' => substr($faker->name, 0, 20),
        'sort' => mt_rand(0, 100),
        'is_show' => \App\Services\Course\Models\CourseCategory::IS_SHOW_YES,
        'parent_id' => 0,
    ];
});
