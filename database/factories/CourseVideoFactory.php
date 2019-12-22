<?php

use Faker\Generator as Faker;

$factory->define(\App\Services\Course\Models\Video::class, function (Faker $faker) {
    return [
        'user_id' => 0,
        'course_id' => function () {
            return factory(\App\Services\Course\Models\Course::class)->create([
                'is_show' => \App\Services\Course\Models\Course::SHOW_YES,
                'published_at' => \Carbon\Carbon::now()->subDays(1),
            ])->id;
        },
        'chapter_id' => function () {
            return factory(\App\Services\Course\Models\CourseChapter::class)->create()->id;
        },
        'title' => $faker->name,
        'slug' => $faker->slug(),
        'url' => $faker->url,
        'view_num' => $faker->randomDigit,
        'charge' => mt_rand(0, 1000),
        'short_description' => $faker->title,
        'original_desc' => $faker->paragraph(),
        'render_desc' => $faker->paragraph(),
        'seo_keywords' => $faker->title,
        'seo_description' => $faker->title,
        'published_at' => $faker->dateTime('now'),
        'is_show' => $faker->randomElement([\App\Models\Video::IS_SHOW_NO, \App\Models\Video::IS_SHOW_YES]),
        'duration' => mt_rand(200, 10000),
    ];
});
