<?php

/*
 * This file is part of the Qsnh/meedu.
 *
 * (c) 杭州白书科技有限公司
 */

namespace Database\Factories\Services\Course\Models;

use App\Services\Course\Models\CourseComment;
use Illuminate\Database\Eloquent\Factories\Factory;

class CourseCommentFactory extends Factory
{
    protected $model = CourseComment::class;

    public function definition()
    {
        return [
            'user_id' => 0,
            'course_id' => 0,
            'original_content' => $this->faker->paragraph,
            'render_content' => $this->faker->paragraph,
        ];
    }
}
