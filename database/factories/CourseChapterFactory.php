<?php

use Faker\Generator as Faker;

$factory->define(\App\Services\Course\Models\CourseChapter::class, function (Faker $faker) {
    return [
        'course_id' => function () {
            return factory(\App\Services\Course\Models\Course::class)->create()->id;
        },
        'title' => $faker->name,
        'sort' => mt_rand(0, 100),
    ];
});
