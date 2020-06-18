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

$factory->define(\App\Services\Member\Models\UserJoinRoleRecord::class, function (Faker $faker) {
    return [
        'user_id' => function () {
            return factory(\App\Services\Member\Models\User::class)->create()->id;
        },
        'role_id' => function () {
            return factory(\App\Services\Member\Models\Role::class)->create()->id;
        },
        'charge' => mt_rand(0, 100),
        'started_at' => \Carbon\Carbon::now(),
        'expired_at' => \Carbon\Carbon::now()->addDays(1),
    ];
});
