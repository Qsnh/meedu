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

$factory->define(\App\Services\Course\Models\Course::class, function (Faker $faker) {
    return [
        'user_id' => 0,
        'category_id' => function () {
            return factory(\App\Services\Course\Models\CourseCategory::class)->create()->id;
        },
        'title' => $faker->name,
        'slug' => $faker->slug(),
        'thumb' => $faker->imageUrl(),
        'charge' => $faker->randomDigit,
        'short_description' => $faker->title,
        'original_desc' => $faker->paragraph(),
        'render_desc' => $faker->paragraph(),
        'seo_keywords' => $faker->title,
        'seo_description' => $faker->title,
        'published_at' => date('Y-m-d H:i:s'),
        'is_show' => $faker->randomElement([\App\Services\Course\Models\Course::SHOW_NO, \App\Services\Course\Models\Course::SHOW_YES]),
        'is_rec' => $faker->randomElement([\App\Services\Course\Models\Course::REC_YES, \App\Services\Course\Models\Course::REC_NO]),
    ];
});
