<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use Faker\Generator as Faker;

$factory->define(\App\Services\Member\Models\UserLikeCourse::class, function (Faker $faker) {
    return [
        'user_id' => 0,
        'course_id' => function () {
            return factory(\App\Services\Course\Models\Course::class)->create()->id;
        },
    ];
});
