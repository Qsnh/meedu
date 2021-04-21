<?php

/*
 * This file is part of the Qsnh/meedu.
 *
 * (c) XiaoTeng <616896861@qq.com>
 */

use Faker\Generator as Faker;

$factory->define(\App\Services\Member\Models\UserInviteBalanceRecord::class, function (Faker $faker) {
    return [
        'user_id' => 0,
        'total' => mt_rand(0, 100),
        'desc' => '',
    ];
});
