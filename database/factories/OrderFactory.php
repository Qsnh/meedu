<?php

/*
 * This file is part of the Qsnh/meedu.
 *
 * (c) 杭州白书科技有限公司
 */

use Faker\Generator as Faker;
use App\Services\Order\Models\Order;

$factory->define(Order::class, function (Faker $faker) {
    return [
        'user_id' => function () {
            return factory(\App\Services\Member\Models\User::class)->create()->id;
        },
        'order_id' => \Illuminate\Support\Str::random(),
        'charge' => mt_rand(1, 1000),
        'status' => $faker->randomElement([Order::STATUS_UNPAY, Order::STATUS_PAID]),
        'payment' => '',
        'payment_method' => '',
    ];
});
