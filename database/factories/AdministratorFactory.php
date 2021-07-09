<?php

/*
 * This file is part of the Qsnh/meedu.
 *
 * (c) 杭州白书科技有限公司
 */

use Faker\Generator as Faker;

$factory->define(\App\Models\Administrator::class, function (Faker $faker) {
    return [
        'name' => substr($faker->name, 0, 10),
        'email' => \Illuminate\Support\Str::random(12) . '@meedu.vip',
        'password' => \Illuminate\Support\Facades\Hash::make('123123'),
    ];
});
