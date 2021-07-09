<?php

/*
 * This file is part of the Qsnh/meedu.
 *
 * (c) 杭州白书科技有限公司
 */

use Faker\Generator as Faker;

$factory->define(\App\Services\Other\Models\AdFrom::class, function (Faker $faker) {
    return [
        'from_name' => $faker->name,
        'from_key' => $faker->name,
    ];
});
