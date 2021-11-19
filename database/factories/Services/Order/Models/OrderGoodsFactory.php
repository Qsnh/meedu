<?php

/*
 * This file is part of the Qsnh/meedu.
 *
 * (c) 杭州白书科技有限公司
 */

namespace Database\Factories\Services\Order\Models;

use App\Services\Member\Models\User;
use App\Services\Order\Models\Order;
use App\Services\Order\Models\OrderGoods;
use Illuminate\Database\Eloquent\Factories\Factory;

class OrderGoodsFactory extends Factory
{
    protected $model = OrderGoods::class;

    public function definition()
    {
        return [
            'user_id' => function () {
                return User::factory()->create()->id;
            },
            'order_id' => '',
            'oid' => function () {
                return Order::factory()->create()->id;
            },
            'goods_type' => $this->faker->randomElement([
                OrderGoods::GOODS_TYPE_ROLE,
                OrderGoods::GOODS_TYPE_VIDEO,
                OrderGoods::GOODS_TYPE_COURSE,
            ]),
            'goods_id' => mt_rand(0, 100),
            'num' => 1,
            'charge' => mt_rand(0, 100),
        ];
    }
}
