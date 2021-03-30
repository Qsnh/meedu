<?php

/*
 * This file is part of the Qsnh/meedu.
 *
 * (c) XiaoTeng <616896861@qq.com>
 */

use Faker\Generator as Faker;

$factory->define(\App\Services\Member\Models\Role::class, function (Faker $faker) {
    return [
        'name' => $faker->name,
        'charge' => $faker->randomDigit,
        'expire_days' => $faker->randomDigit,
        'weight' => $faker->randomDigit,
        'description' => $faker->name,
    ];
});
