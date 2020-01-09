<?php

namespace Tests\Feature\Page;

use App\Services\Course\Models\Video;
use Carbon\Carbon;
use Tests\TestCase;

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
