<?php

/*
 * This file is part of the Qsnh/meedu.
 *
 * (c) 杭州白书科技有限公司
 */

use Faker\Generator as Faker;

$factory->define(\App\Services\Member\Models\UserInviteBalanceRecord::class, function (Faker $faker) {
    return [
        'user_id' => 0,
        'total' => mt_rand(0, 100),
        'desc' => '',
    ];
});
