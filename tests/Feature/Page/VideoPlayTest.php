<?php

/*
 * This file is part of the Qsnh/meedu.
 *
 * (c) XiaoTeng <616896861@qq.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace Tests\Feature\Page;

use Carbon\Carbon;
use Tests\TestCase;
use App\Services\Course\Models\Video;

class VideoPlayTest extends TestCase
{
    public function test_visit()
    {
        $video = factory(Video::class)->create([
            'is_show' => Video::IS_SHOW_YES,
            'published_at' => Carbon::now()->subDay(1),
        ]);
        $response = $this->get(route('video.show', [$video->course, $video->id, $video->slug]));
        $response->assertResponseStatus(200);
    }

    public function test_visit_no_show()
    {
        $video = factory(Video::class)->create([
            'is_show' => Video::IS_SHOW_NO,
            'published_at' => Carbon::now()->subDay(1),
        ]);
        $response = $this->get(route('video.show', [$video->course, $video->id, $video->slug]));
        $response->assertResponseStatus(404);
    }

    public function test_visit_no_published()
    {
        $video = factory(Video::class)->create([
            'is_show' => Video::IS_SHOW_YES,
            'published_at' => Carbon::now()->addDays(1),
        ]);
        $response = $this->get(route('video.show', [$video->course, $video->id, $video->slug]));
        $response->assertResponseStatus(404);
    }
}
