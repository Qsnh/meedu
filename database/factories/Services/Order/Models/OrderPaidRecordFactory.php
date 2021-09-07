<?php

/*
 * This file is part of the Qsnh/meedu.
 *
 * (c) 杭州白书科技有限公司
 */

namespace Database\Factories\Services\Order\Models;

use App\Services\Order\Models\OrderPaidRecord;
use Illuminate\Database\Eloquent\Factories\Factory;

class OrderPaidRecordFactory extends Factory
{
    protected $model = OrderPaidRecord::class;

    public function definition()
    {
        return [
            'user_id' => 0,
            'order_id' => 0,
            'paid_total' => mt_rand(0, 100),
            'paid_type' => $this->faker->randomElement([
                OrderPaidRecord::PAID_TYPE_DEFAULT,
                OrderPaidRecord::PAID_TYPE_PROMO_CODE,
                OrderPaidRecord::PAID_TYPE_INVITE_BALANCE,
            ]),
            'paid_type_id' => 0,
        ];
    }
}
