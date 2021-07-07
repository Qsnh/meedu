<?php

/*
 * This file is part of the Qsnh/meedu.
 *
 * (c) 杭州白书科技有限公司
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
