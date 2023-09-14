<?php

/*
 * This file is part of the MeEdu.
 *
 * (c) 杭州白书科技有限公司
 */

namespace Database\Factories\Services\Member\Models;

use Carbon\Carbon;
use App\Services\Member\Models\User;
use App\Services\Course\Models\Course;
use App\Services\Member\Models\UserCourse;
use Illuminate\Database\Eloquent\Factories\Factory;

class UserCourseFactory extends Factory
{
    protected $model = UserCourse::class;

    public function definition()
    {
        return [
            'user_id' => function () {
                return User::factory()->create()->id;
            },
            'course_id' => function () {
                return Course::factory()->create([
                    'is_show' => Course::SHOW_YES,
                    'published_at' => Carbon::now()->subDays(1),
                ])->id;
            },
            'charge' => mt_rand(0, 100),
            'created_at' => Carbon::now(),
        ];
    }
}
