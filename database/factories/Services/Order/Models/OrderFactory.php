<?php

/*
 * This file is part of the MeEdu.
 *
 * (c) 杭州白书科技有限公司
 */

namespace Database\Factories\Services\Order\Models;

use Illuminate\Support\Str;
use App\Services\Member\Models\User;
use App\Services\Order\Models\Order;
use Illuminate\Database\Eloquent\Factories\Factory;

class OrderFactory extends Factory
{
    protected $model = Order::class;

    public function definition()
    {
        return [
            'user_id' => function () {
                return User::factory()->create()->id;
            },
            'order_id' => Str::random(12),
            'charge' => mt_rand(1, 1000),
            'status' => $this->faker->randomElement([Order::STATUS_UNPAY, Order::STATUS_PAID]),
            'payment' => '',
            'payment_method' => '',
        ];
    }
}
