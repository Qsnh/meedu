<?php

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
        'is_show' => $faker->randomElement([\App\Models\Course::SHOW_NO, \App\Models\Course::SHOW_YES]),
        'is_rec' => $faker->randomElement([\App\Models\Course::REC_YES, \App\Models\Course::REC_NO]),
    ];
});
