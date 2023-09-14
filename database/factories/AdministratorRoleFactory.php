<?php

/*
 * This file is part of the MeEdu.
 *
 * (c) 杭州白书科技有限公司
 */

namespace Database\Factories;

use App\Models\AdministratorRole;
use Illuminate\Database\Eloquent\Factories\Factory;

class AdministratorRoleFactory extends Factory
{
    protected $model = AdministratorRole::class;

    public function definition()
    {
        return [
            'display_name' => '超级管路员角色',
            'slug' => config('meedu.administrator.super_slug'),
            'description' => '',
        ];
    }
}
