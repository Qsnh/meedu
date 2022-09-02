<?php

/*
 * This file is part of the Qsnh/meedu.
 *
 * (c) 杭州白书科技有限公司
 */

namespace Database\Factories\Meedu\ServiceV2\Models;

use Carbon\Carbon;
use App\Meedu\ServiceV2\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Eloquent\Factories\Factory;

class UserFactory extends Factory
{
    protected $model = User::class;

    public function definition()
    {
        return [
            'avatar' => $this->faker->imageUrl(),
            'nick_name' => $this->faker->firstName . mt_rand(0, 100),
            'mobile' => $this->faker->randomElement(['136', '188', '159']) . mt_rand(1000, 9999) . mt_rand(1000, 9999),
            'password' => Hash::make('123456'),
            'credit1' => 0,
            'credit2' => 0,
            'credit3' => 0,
            'is_active' => $this->faker->randomElement([0,1]),
            'is_lock' => $this->faker->randomElement([0,1]),
            'role_id' => 0,
            'role_expired_at' => Carbon::now(),
        ];
    }
}
