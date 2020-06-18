<?php

/*
 * This file is part of the Qsnh/meedu.
 *
 * (c) XiaoTeng <616896861@qq.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

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
