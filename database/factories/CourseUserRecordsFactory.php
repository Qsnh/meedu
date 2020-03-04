<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use Faker\Generator as Faker;

$factory->define(\App\Services\Course\Models\CourseUserRecord::class, function (Faker $faker) {
    return [
        'course_id' => function () {
            return factory(\App\Services\Course\Models\Course::class)->create()->id;
        },
        'user_id' => function () {
            return factory(\App\Services\Member\Models\User::class)->create()->id;
        }
    ];
});
