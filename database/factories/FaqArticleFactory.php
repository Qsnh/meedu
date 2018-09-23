<?php

use Faker\Generator as Faker;

$factory->define(\App\Models\FaqArticle::class, function (Faker $faker) {
    return [
        'category_id' => function () {
            return factory(\App\Models\FaqCategory::class)->create()->id;
        },
        'admin_id' => function () {
            return factory(\App\Models\Administrator::class)->create()->id;
        },
        'title' => $faker->title,
        'content' => $faker->paragraph,
    ];
});
