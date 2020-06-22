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

$factory->define(\App\Services\Member\Models\UserVideo::class, function (Faker $faker) {
    return [
        'user_id' => function () {
            return factory(\App\Services\Member\Models\User::class)->create()->id;
        },
        'video_id' => function () {
            return factory(\App\Services\Course\Models\Video::class)->create([
                'is_show' => \App\Services\Course\Models\Video::IS_SHOW_YES,
                'published_at' => \Carbon\Carbon::now()->subDays(1),
            ]);
        },
        'charge' => mt_rand(0, 100),
        'created_at' => \Carbon\Carbon::now(),
    ];
});
