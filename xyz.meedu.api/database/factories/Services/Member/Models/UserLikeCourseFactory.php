<?php

/*
 * This file is part of the MeEdu.
 *
 * (c) 杭州白书科技有限公司
 */

namespace Database\Factories\Services\Member\Models;

use App\Services\Course\Models\Course;
use App\Services\Member\Models\UserLikeCourse;
use Illuminate\Database\Eloquent\Factories\Factory;

class UserLikeCourseFactory extends Factory
{
    protected $model = UserLikeCourse::class;

    public function definition()
    {
        return [
            'user_id' => 0,
            'course_id' => function () {
                return Course::factory()->create()->id;
            },
        ];
    }
}
