<?php

/*
 * This file is part of the MeEdu.
 *
 * (c) 杭州白书科技有限公司
 */

namespace Database\Factories\Services\Course\Models;

use App\Services\Member\Models\User;
use App\Services\Course\Models\Course;
use App\Services\Course\Models\CourseUserRecord;
use Illuminate\Database\Eloquent\Factories\Factory;

class CourseUserRecordFactory extends Factory
{
    protected $model = CourseUserRecord::class;

    public function definition()
    {
        return [
            'course_id' => function () {
                return Course::factory()->create()->id;
            },
            'user_id' => function () {
                return User::factory()->create()->id;
            }
        ];
    }
}
