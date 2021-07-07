<?php

/*
 * This file is part of the Qsnh/meedu.
 *
 * (c) 杭州白书科技有限公司
 */

use Faker\Generator as Faker;

$factory->define(\App\Services\Other\Models\Announcement::class, function (Faker $faker) {
    return [
        'title' => $faker->title,
        'admin_id' => function () {
            return factory(\App\Models\Administrator::class)->create()->id;
        },
        'announcement' => $faker->title,
        'created_at' => \Carbon\Carbon::now(),
    ];
});
