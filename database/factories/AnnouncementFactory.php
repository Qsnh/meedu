<?php

use Faker\Generator as Faker;

$factory->define(\App\Models\Announcement::class, function (Faker $faker) {
    return [
        'admin_id' => function () {
            return factory(\App\Models\Administrator::class)->create()->id;
        },
        'announcement' => $faker->title,
    ];
});
