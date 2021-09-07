<?php

/*
 * This file is part of the Qsnh/meedu.
 *
 * (c) 杭州白书科技有限公司
 */

namespace Database\Factories\Services\Course\Models;

use Carbon\Carbon;
use App\Services\Course\Models\Video;
use App\Services\Course\Models\Course;
use App\Services\Course\Models\CourseChapter;
use Illuminate\Database\Eloquent\Factories\Factory;

class VideoFactory extends Factory
{
    protected $model = Video::class;

    public function definition()
    {
        return [
            'user_id' => 0,
            'course_id' => function () {
                return Course::factory()->create([
                    'is_show' => Course::SHOW_YES,
                    'published_at' => Carbon::now()->subDays(1),
                ])->id;
            },
            'chapter_id' => function () {
                return CourseChapter::factory()->create()->id;
            },
            'title' => $this->faker->name,
            'slug' => $this->faker->slug(),
            'url' => $this->faker->url,
            'view_num' => $this->faker->randomDigit,
            'charge' => random_int(0, 1000),
            'short_description' => $this->faker->title,
            'original_desc' => $this->faker->paragraph(),
            'render_desc' => $this->faker->paragraph(),
            'seo_keywords' => $this->faker->title,
            'seo_description' => $this->faker->title,
            'published_at' => Carbon::now(),
            'is_show' => $this->faker->randomElement([Video::IS_SHOW_NO, Video::IS_SHOW_YES]),
            'duration' => random_int(200, 10000),
        ];
    }
}
