<?php

/*
 * This file is part of the Qsnh/meedu.
 *
 * (c) 杭州白书科技有限公司
 */

namespace Database\Factories;

use Illuminate\Support\Str;
use App\Models\Administrator;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Eloquent\Factories\Factory;

class AdministratorFactory extends Factory
{
    protected $model = Administrator::class;

    public function definition()
    {
        return [
            'name' => substr($this->faker->name, 0, 10),
            'email' => Str::random(12) . '@meedu.vip',
            'password' => Hash::make('123123'),
        ];
    }
}
