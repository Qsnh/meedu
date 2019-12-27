<?php

use Faker\Generator as Faker;

$factory->define(\App\Services\Course\Models\VideoComment::class, function (Faker $faker) {
    return [
        'user_id' => function () {
            return factory(\App\Services\Member\Models\User::class)->create()->id;
        },
        'video_id' => function () {
            return factory(\App\Services\Course\Models\Course::class)->create()->id;
        },
        'original_content' => $faker->paragraph,
        'render_content' => $faker->paragraph,
    ];
});
