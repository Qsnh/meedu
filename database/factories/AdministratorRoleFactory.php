<?php

/*
 * This file is part of the Qsnh/meedu.
 *
 * (c) 杭州白书科技有限公司
 */

use Faker\Generator as Faker;

$factory->define(\App\Models\AdministratorRole::class, function (Faker $faker) {
    return [
        'display_name' => '超级管路员角色',
        'slug' => config('meedu.administrator.super_slug'),
        'description' => '',
    ];
});
