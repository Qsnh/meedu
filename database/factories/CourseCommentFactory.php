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

$factory->define(\App\Services\Course\Models\CourseComment::class, function (Faker $faker) {
    return [
        'user_id' => 0,
        'course_id' => 0,
        'original_content' => $faker->paragraph,
        'render_content' => $faker->paragraph,
    ];
});
