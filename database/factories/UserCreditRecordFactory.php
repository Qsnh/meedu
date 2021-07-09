<?php

/*
 * This file is part of the Qsnh/meedu.
 *
 * (c) 杭州白书科技有限公司
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
