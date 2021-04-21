<?php

/*
 * This file is part of the Qsnh/meedu.
 *
 * (c) XiaoTeng <616896861@qq.com>
 */

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
