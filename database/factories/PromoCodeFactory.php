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

$factory->define(\App\Services\Order\Models\PromoCode::class, function (Faker $faker) {
    return [
        'user_id' => 0,
        'code' => \Illuminate\Support\Str::random(),
        'expired_at' => null,
        'invite_user_reward' => mt_rand(0, 100),
        'invited_user_reward' => mt_rand(0, 100),
        'use_times' => 1,
        'used_times' => 0,
    ];
});
