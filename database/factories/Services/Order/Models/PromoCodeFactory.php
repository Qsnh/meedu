<?php

/*
 * This file is part of the Qsnh/meedu.
 *
 * (c) 杭州白书科技有限公司
 */

namespace Database\Factories\Services\Order\Models;

use Illuminate\Support\Str;
use App\Services\Order\Models\PromoCode;
use Illuminate\Database\Eloquent\Factories\Factory;

class PromoCodeFactory extends Factory
{
    protected $model = PromoCode::class;

    public function definition()
    {
        return [
            'user_id' => 0,
            'code' => Str::random(12),
            'expired_at' => null,
            'invite_user_reward' => mt_rand(0, 100),
            'invited_user_reward' => mt_rand(0, 100),
            'use_times' => 1,
            'used_times' => 0,
        ];
    }
}
