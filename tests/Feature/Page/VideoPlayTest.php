<?php

namespace Tests\Feature\Page;

use App\Models\Video;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class VideoPlayTest extends TestCase
{

    public function test_visit()
    {
        $video = factory(Video::class)->create([
            'is_show' => Video::IS_SHOW_YES,
            'published_at' => date('Y-m-d H:i:s', time() - 1000),
        ]);
        $response = $this->get(route('video.show', [$video->course, $video->id, $video->slug]));
        $response->assertResponseStatus(200);
    }

    public function test_visit_no_show()
    {
        $video = factory(Video::class)->create([
            'is_show' => Video::IS_SHOW_NO,
            'published_at' => date('Y-m-d H:i:s', time() - 1000),
        ]);
        $response = $this->get(route('video.show', [$video->course, $video->id, $video->slug]));
        $response->assertResponseStatus(404);
    }

    public function test_visit_no_published()
    {
        $video = factory(Video::class)->create([
            'is_show' => Video::IS_SHOW_YES,
            'published_at' => date('Y-m-d H:i:s', time() + 1000),
        ]);
        $response = $this->get(route('video.show', [$video->course, $video->id, $video->slug]));
        $response->assertResponseStatus(404);
    }

}
