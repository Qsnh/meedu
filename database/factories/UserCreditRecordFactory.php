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

$factory->define(\App\Services\Member\Models\UserCreditRecord::class, function (Faker $faker) {
    return [
        'user_id' => 0,
        'field' => 'credit1',
        'sum' => mt_rand(1, 1000),
        'remark' => $faker->name,
    ];
});
