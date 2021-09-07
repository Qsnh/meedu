<?php

/*
 * This file is part of the Qsnh/meedu.
 *
 * (c) 杭州白书科技有限公司
 */

namespace Database\Factories\Services\Course\Models;

use App\Services\Course\Models\CourseCategory;
use Illuminate\Database\Eloquent\Factories\Factory;

class CourseCategoryFactory extends Factory
{
    protected $model = CourseCategory::class;

    public function definition()
    {
        return [
            'name' => substr($this->faker->name, 0, 20),
            'sort' => mt_rand(0, 100),
            'is_show' => 1,
            'parent_id' => 0,
        ];
    }
}
