<?php

/*
 * This file is part of the Qsnh/meedu.
 *
 * (c) 杭州白书科技有限公司
 */

namespace Database\Factories\Meedu\ServiceV2\Models;

use Carbon\Carbon;
use App\Meedu\ServiceV2\Models\User;
use App\Meedu\ServiceV2\Models\UserDeleteJob;
use Illuminate\Database\Eloquent\Factories\Factory;

class UserDeleteJobFactory extends Factory
{
    protected $model = UserDeleteJob::class;

    public function definition()
    {
        $fakerUser = User::factory()->create();
        return [
            'user_id' => $fakerUser['id'],
            'mobile' => $fakerUser['mobile'],
            'submit_at' => Carbon::now(),
            'expired_at' => Carbon::now()->addDays(7),
        ];
    }
}
