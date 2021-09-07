<?php

/*
 * This file is part of the Qsnh/meedu.
 *
 * (c) 杭州白书科技有限公司
 */

namespace Database\Factories\Services\Member\Models;

use Carbon\Carbon;
use App\Services\Member\Models\Role;
use App\Services\Member\Models\User;
use App\Services\Member\Models\UserJoinRoleRecord;
use Illuminate\Database\Eloquent\Factories\Factory;

class UserJoinRoleRecordFactory extends Factory
{
    protected $model = UserJoinRoleRecord::class;

    public function definition()
    {
        return [
            'user_id' => function () {
                return User::factory()->create()->id;
            },
            'role_id' => function () {
                return Role::factory()->create()->id;
            },
            'charge' => mt_rand(0, 100),
            'started_at' => Carbon::now(),
            'expired_at' => Carbon::now()->addDays(1),
        ];
    }
}
