<?php

/*
 * This file is part of the MeEdu.
 *
 * (c) 杭州白书科技有限公司
 */

namespace Database\Factories\Services\Member\Models;

use Illuminate\Support\Str;
use App\Services\Member\Models\User;
use App\Services\Member\Models\Socialite;
use Illuminate\Database\Eloquent\Factories\Factory;

class UserSocialiteFactory extends Factory
{
    protected $model = Socialite::class;

    public function definition()
    {
        return [
            'user_id' => function () {
                return User::factory()->create()->id;
            },
            'app' => 'qq',
            'app_user_id' => Str::random(),
            'data' => '',
        ];
    }
}
