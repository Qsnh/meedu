<?php

/*
 * This file is part of the MeEdu.
 *
 * (c) 杭州白书科技有限公司
 */

namespace Database\Factories\Services\Member\Models;

use App\Services\Member\Models\UserCreditRecord;
use Illuminate\Database\Eloquent\Factories\Factory;

class UserCreditRecordFactory extends Factory
{
    protected $model = UserCreditRecord::class;

    public function definition()
    {
        return [
            'user_id' => 0,
            'field' => 'credit1',
            'sum' => mt_rand(1, 1000),
            'remark' => $this->faker->name,
        ];
    }
}
