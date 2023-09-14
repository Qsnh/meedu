<?php

/*
 * This file is part of the MeEdu.
 *
 * (c) 杭州白书科技有限公司
 */

namespace Database\Factories\Services\Course\Models;

use App\Services\Course\Models\Course;
use App\Services\Course\Models\CourseChapter;
use Illuminate\Database\Eloquent\Factories\Factory;

class CourseChapterFactory extends Factory
{
    protected $model = CourseChapter::class;

    public function definition()
    {
        return [
            'course_id' => function () {
                return Course::factory()->create()->id;
            },
            'title' => $this->faker->name,
            'sort' => mt_rand(0, 100),
        ];
    }
}
