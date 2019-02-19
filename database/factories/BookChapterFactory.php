<?php

use Faker\Generator as Faker;

$factory->define(\App\Models\BookChapter::class, function (Faker $faker) {
    return [
        'user_id' => 0,
        'book_id' => function () {
            return factory(\App\Models\Book::class)->create()->id;
        },
        'title' => $faker->title,
        'content' => $faker->paragraph,
        'view_num' => 0,
        'published_at' => \Carbon\Carbon::now(),
        'is_show' => $faker->randomElement([\App\Models\BookChapter::SHOW_NO, \App\Models\BookChapter::SHOW_YES]),
    ];
});
