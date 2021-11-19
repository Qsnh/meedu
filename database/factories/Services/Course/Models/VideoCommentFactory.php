<?php

/*
 * This file is part of the Qsnh/meedu.
 *
 * (c) 杭州白书科技有限公司
 */

namespace Database\Factories\Services\Course\Models;

use App\Services\Member\Models\User;
use App\Services\Course\Models\Video;
use App\Services\Course\Models\VideoComment;
use Illuminate\Database\Eloquent\Factories\Factory;

class VideoCommentFactory extends Factory
{
    protected $model = VideoComment::class;

    public function definition()
    {
        return [
            'user_id' => function () {
                return User::factory()->create()->id;
            },
            'video_id' => function () {
                return Video::factory()->create()->id;
            },
            'original_content' => $this->faker->paragraph,
            'render_content' => $this->faker->paragraph,
        ];
    }
}
