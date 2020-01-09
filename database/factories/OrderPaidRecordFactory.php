<?php

use App\Services\Order\Models\OrderPaidRecord;
use Faker\Generator as Faker;

$factory->define(OrderPaidRecord::class, function (Faker $faker) {
    return [
        'user_id' => 0,
        'order_id' => 0,
        'paid_total' => mt_rand(0, 100),
        'paid_type' => $faker->randomElement([OrderPaidRecord::PAID_TYPE_DEFAULT, OrderPaidRecord::PAID_TYPE_PROMO_CODE, OrderPaidRecord::PAID_TYPE_INVITE_BALANCE]),
        'paid_type_id' => 0,
    ];
});
