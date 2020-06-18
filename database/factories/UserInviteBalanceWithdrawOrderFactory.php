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

$factory->define(\App\Services\Member\Models\UserInviteBalanceWithdrawOrder::class, function (Faker $faker) {
    return [
        'user_id' => 0,
        'total' => mt_rand(0, 100),
        'channel' => '支付宝',
        'channel_name' => $faker->name,
        'channel_account' => $faker->email,
        'channel_address' => $faker->address,
        'status' => \App\Services\Member\Models\UserInviteBalanceWithdrawOrder::STATUS_DEFAULT,
    ];
});
