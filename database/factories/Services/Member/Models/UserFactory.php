<?php

/*
 * This file is part of the Qsnh/meedu.
 *
 * (c) 杭州白书科技有限公司
 */

namespace Database\Factories\Services\Member\Models;

use Carbon\Carbon;
use App\Services\Member\Models\User;
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
            'is_active' => $this->faker->randomElement([User::ACTIVE_NO, User::ACTIVE_YES]),
            'is_lock' => $this->faker->randomElement([User::LOCK_NO, User::LOCK_YES]),
            'role_id' => 0,
            'role_expired_at' => Carbon::now(),
        ];
    }
}
