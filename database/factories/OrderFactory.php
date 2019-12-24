<?php

use Faker\Generator as Faker;

$factory->define(\App\Services\Order\Models\Order::class, function (Faker $faker) {
    return [
        'user_id' => function () {
            return factory(\App\User::class)->create()->id;
        },
        'goods_id' => mt_rand(0, 10),
        'goods_type' => $faker->randomElement([\App\Models\Order::GOODS_TYPE_COURSE, \App\Models\Order::GOODS_TYPE_ROLE, \App\Models\Order::GOODS_TYPE_VIDEO]),
        'charge' => mt_rand(1, 1000),
        'status' => $faker->randomElement([\App\Models\Order::STATUS_UNPAY, \App\Models\Order::STATUS_PAID]),
        'extra' => '',
    ];
});
