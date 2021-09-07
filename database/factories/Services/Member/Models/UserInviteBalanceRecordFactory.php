<?php

/*
 * This file is part of the Qsnh/meedu.
 *
 * (c) 杭州白书科技有限公司
 */

namespace Database\Factories\Services\Member\Models;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Services\Member\Models\UserInviteBalanceRecord;

class UserInviteBalanceRecordFactory extends Factory
{
    protected $model = UserInviteBalanceRecord::class;

    public function definition()
    {
        return [
            'user_id' => 0,
            'total' => mt_rand(0, 100),
            'desc' => '',
        ];
    }
}
