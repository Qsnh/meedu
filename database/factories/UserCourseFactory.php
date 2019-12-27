<?php

use Faker\Generator as Faker;

$factory->define(\App\Services\Member\Models\UserCourse::class, function (Faker $faker) {
    return [
        'user_id' => function () {
            return factory(\App\Services\Member\Models\User::class)->create()->id;
        },
        'course_id' => function () {
            return factory(\App\Services\Course\Models\Course::class)->create([
                'is_show' => \App\Services\Course\Models\Course::SHOW_YES,
                'published_at' => \Carbon\Carbon::now()->subDays(1),
            ]);
        },
        'charge' => mt_rand(0, 100),
        'created_at' => \Carbon\Carbon::now(),
    ];
});
