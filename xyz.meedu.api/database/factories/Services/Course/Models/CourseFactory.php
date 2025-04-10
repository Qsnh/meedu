<?php

/*
 * This file is part of the MeEdu.
 *
 * (c) 杭州白书科技有限公司
 */

namespace Database\Factories\Services\Course\Models;

use Carbon\Carbon;
use App\Services\Course\Models\Course;
use App\Services\Course\Models\CourseCategory;
use Illuminate\Database\Eloquent\Factories\Factory;

class CourseFactory extends Factory
{
    protected $model = Course::class;

    public function definition()
    {
        return [
            'user_id' => 0,
            'category_id' => function () {
                return CourseCategory::factory()->create()->id;
            },
            'title' => $this->faker->name,
            'slug' => $this->faker->slug(),
            'thumb' => $this->faker->imageUrl(),
            'charge' => $this->faker->randomDigit,
            'short_description' => $this->faker->title,
            'original_desc' => $this->faker->paragraph(),
            'render_desc' => $this->faker->paragraph(),
            'seo_keywords' => $this->faker->title,
            'seo_description' => $this->faker->title,
            'published_at' => Carbon::now(),
            'is_show' => $this->faker->randomElement([Course::SHOW_NO, Course::SHOW_YES]),
            'is_rec' => $this->faker->randomElement([Course::REC_YES, Course::REC_NO]),
            'is_allow_comment' => $this->faker->randomElement([0, 1]),
        ];
    }
}
