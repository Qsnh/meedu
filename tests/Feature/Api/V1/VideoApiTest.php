<?php

namespace Tests\Feature\Api\V1;

use App\Http\Resources\UserResource;
use App\Http\Resources\VideoRecourse;
use App\Models\Course;
use App\Models\Video;
use App\User;
use Carbon\Carbon;
use Laravel\Passport\Passport;
use Tests\OriginalTestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class VideoApiTest extends OriginalTestCase
{

    public function test_video_list()
    {
        $video = factory(Video::class)->create([
            'is_show' => Video::IS_SHOW_YES,
            'published_at' => Carbon::now()->subDay(1),
        ]);
        $this->json('GET', '/api/v1/video/'.$video->id)
            ->assertJsonFragment([
                'data' => (new VideoRecourse($video))->toArray(request()),
            ]);
    }

    public function test_video_comment()
    {
        $user = factory(User::class)->create();
        Passport::actingAs($user);
        $video = factory(Video::class)->create([
            'is_show' => Video::IS_SHOW_YES,
            'published_at' => Carbon::now()->subDay(1),
        ]);
        $content = '你好，我是测试的视频评论';
        $this->json('POST', '/api/v1/video/'.$video->id.'/comment', [
            'content' => $content,
        ])->assertJsonFragment([
            'content' => markdown_to_html($content),
        ]);
    }

}
