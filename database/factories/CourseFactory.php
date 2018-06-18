<?php

use Faker\Generator as Faker;

$factory->define(\App\Models\Course::class, function (Faker $faker) {
    return [
        'user_id' => 0,
        'title' => $faker->text(),
        'slug' => $faker->slug(),
        'thumb' => $faker->imageUrl(),
        'charge' => $faker->randomDigit,
        'short_description' => $faker->text(),
        'description' => $faker->paragraph(),
        'seo_keywords' => $faker->text(),
        'seo_description' => $faker->text(),
        'published_at' => date('Y-m-d H:i:s'),
        'is_show' => $faker->randomElement([\App\Models\Course::SHOW_NO, \App\Models\Course::SHOW_YES]),
    ];
});
