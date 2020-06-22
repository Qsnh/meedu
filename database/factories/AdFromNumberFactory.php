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

$factory->define(\App\Services\Other\Models\AdFromNumber::class, function (Faker $faker) {
    return [
        'from_id' => function () {
            return factory(\App\Services\Other\Models\AdFrom::class)->create()->id;
        },
        'day' => $faker->date(),
        'num' => mt_rand(0, 100),
    ];
});
