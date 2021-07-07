<?php

/*
 * This file is part of the Qsnh/meedu.
 *
 * (c) 杭州白书科技有限公司
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
