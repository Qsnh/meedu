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
use App\Services\Order\Models\OrderPaidRecord;

$factory->define(OrderPaidRecord::class, function (Faker $faker) {
    return [
        'user_id' => 0,
        'order_id' => 0,
        'paid_total' => mt_rand(0, 100),
        'paid_type' => $faker->randomElement([OrderPaidRecord::PAID_TYPE_DEFAULT, OrderPaidRecord::PAID_TYPE_PROMO_CODE, OrderPaidRecord::PAID_TYPE_INVITE_BALANCE]),
        'paid_type_id' => 0,
    ];
});
