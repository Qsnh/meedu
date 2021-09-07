<?php

/*
 * This file is part of the Qsnh/meedu.
 *
 * (c) 杭州白书科技有限公司
 */

namespace Database\Factories\Services\Member\Models;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Services\Member\Models\UserInviteBalanceWithdrawOrder;

class UserInviteBalanceWithdrawOrderFactory extends Factory
{
    protected $model = UserInviteBalanceWithdrawOrder::class;

    public function definition()
    {
        return [
            'user_id' => 0,
            'total' => mt_rand(0, 100),
            'channel' => '支付宝',
            'channel_name' => $this->faker->name,
            'channel_account' => $this->faker->email,
            'channel_address' => $this->faker->address,
            'status' => UserInviteBalanceWithdrawOrder::STATUS_DEFAULT,
        ];
    }
}
