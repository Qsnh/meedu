<?php

use Faker\Generator as Faker;

$factory->define(\App\Models\Book::class, function (Faker $faker) {
    return [
        'user_id' => 0,
        'title' => $faker->title,
        'slug' => str_random(42),
        'thumb' => $faker->image(),
        'view_num' => 0,
        'charge' => mt_rand(0, 100),
        'short_description' => $faker->title,
        'description' => $faker->paragraph,
        'seo_keywords' => $faker->name,
        'seo_description' => $faker->title,
        'published_at' => \Carbon\Carbon::now(),
        'is_show' => $faker->randomElement([\App\Models\Book::SHOW_YES, \App\Models\Book::SHOW_NO]),
    ];
});
