<?php


namespace Tests\Feature\Api\V2;


use App\Services\Course\Models\Video;
use App\Services\Course\Models\VideoComment;
use App\Services\Member\Models\User;
use Carbon\Carbon;

class VideoTest extends Base
{

    public function test_videos()
    {
        factory(Video::class, 10)->create([
            'is_show' => Video::IS_SHOW_YES,
            'published_at' => Carbon::now()->subDays(1),
        ]);
        $r = $this->getJson('api/v2/videos');
        $r = $this->assertResponseSuccess($r);
        $this->assertEquals(10, $r['data']['total']);
    }

    public function test_video_id()
    {
        $video = factory(Video::class)->create([
            'is_show' => Video::IS_SHOW_YES,
            'published_at' => Carbon::now()->subDays(1),
        ]);
        $r = $this->getJson('api/v2/video/' . $video->id);
        $r = $this->assertResponseSuccess($r);
    }

    public function test_video_id_with_no_id()
    {
        $r = $this->getJson('api/v2/video/' . random_int(0, 1000));
        $this->assertResponseError($r, __('error'));
    }

    public function test_video_id_no_show()
    {
        $video = factory(Video::class)->create([
            'is_show' => Video::IS_SHOW_NO,
            'published_at' => Carbon::now()->subDays(1),
        ]);
        $r = $this->getJson('api/v2/video/' . $video->id);
        $this->assertResponseError($r, __('error'));
    }

    public function test_video_id_no_published()
    {
        $video = factory(Video::class)->create([
            'is_show' => Video::IS_SHOW_YES,
            'published_at' => Carbon::now()->addDays(1),
        ]);
        $r = $this->getJson('api/v2/video/' . $video->id);
        $this->assertResponseError($r, __('error'));
    }

    public function test_video_comment()
    {
        $user = factory(User::class)->create();

        $video = factory(Video::class)->create([
            'is_show' => Video::IS_SHOW_YES,
            'published_at' => Carbon::now()->subDays(1),
        ]);
        $r = $this->user($user)->postJson('api/v2/video/' . $video->id . '/comment', [
            'content' => 'hello meedu',
        ]);
        $r = $this->assertResponseSuccess($r);

        $comment = VideoComment::whereUserId($user->id)->whereVideoId($video->id)->first();
        $this->assertNotEmpty($comment);
        $this->assertEquals('hello meedu', $comment->original_content);
    }

    public function test_video_comments()
    {
        $video = factory(Video::class)->create([
            'is_show' => Video::IS_SHOW_YES,
            'published_at' => Carbon::now()->subDays(1),
        ]);
        factory(VideoComment::class, 12)->create([
            'video_id' => $video->id,
        ]);
        $r = $this->getJson('api/v2/video/' . $video->id . '/comments');
        $r = $this->assertResponseSuccess($r);
        $this->assertEquals(12, count($r['data']['comments']));
    }

}