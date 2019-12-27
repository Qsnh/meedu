<?php

use Faker\Generator as Faker;

$factory->define(\App\Services\Order\Models\OrderGoods::class, function (Faker $faker) {
    return [
        'user_id' => function () {
            return factory(\App\Services\Member\Models\User::class)->create()->id;
        },
        'order_id' => '',
        'oid' => function () {
            return factory(\App\Services\Order\Models\Order::class)->create()->id;
        },
        'goods_type' => $faker->randomElement([
            \App\Services\Order\Models\OrderGoods::GOODS_TYPE_ROLE,
            \App\Services\Order\Models\OrderGoods::GOODS_TYPE_VIDEO,
            \App\Services\Order\Models\OrderGoods::GOODS_TYPE_COURSE,
        ]),
        'goods_id' => mt_rand(0, 100),
        'num' => 1,
        'charge' => mt_rand(0, 100),
    ];
});
