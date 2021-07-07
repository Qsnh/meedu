<?php

/*
 * This file is part of the Qsnh/meedu.
 *
 * (c) 杭州白书科技有限公司
 */

use Faker\Generator as Faker;

$factory->define(\App\Services\Other\Models\IndexBanner::class, function (Faker $faker) {
    return [
        'sort' => $faker->randomDigit,
        'name' => $faker->name,
        'course_ids' => '1,2',
    ];
});
