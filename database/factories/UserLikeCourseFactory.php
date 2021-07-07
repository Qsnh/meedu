<?php

/*
 * This file is part of the Qsnh/meedu.
 *
 * (c) 杭州白书科技有限公司
 */

use Faker\Generator as Faker;

$factory->define(\App\Services\Member\Models\UserLikeCourse::class, function (Faker $faker) {
    return [
        'user_id' => 0,
        'course_id' => function () {
            return factory(\App\Services\Course\Models\Course::class)->create()->id;
        },
    ];
});
