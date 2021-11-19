<?php

/*
 * This file is part of the Qsnh/meedu.
 *
 * (c) 杭州白书科技有限公司
 */

namespace Database\Factories\Services\Member\Models;

use App\Services\Member\Models\Role;
use Illuminate\Database\Eloquent\Factories\Factory;

class RoleFactory extends Factory
{
    protected $model = Role::class;

    public function definition()
    {
        return [
            'name' => $this->faker->name,
            'charge' => $this->faker->randomDigit,
            'expire_days' => $this->faker->randomDigit,
            'weight' => $this->faker->randomDigit,
            'description' => $this->faker->name,
        ];
    }
}
