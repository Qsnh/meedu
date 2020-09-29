<?php

/*
 * This file is part of the Qsnh/meedu.
 *
 * (c) XiaoTeng <616896861@qq.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace Tests\Feature\Api\V2;

use Carbon\Carbon;
use App\Constant\CacheConstant;
use App\Services\Member\Models\Role;
use App\Services\Member\Models\User;
use App\Services\Course\Models\Video;
use Illuminate\Support\Facades\Cache;
use App\Services\Course\Models\Course;
use App\Services\Member\Models\UserVideo;
use App\Services\Member\Models\UserCourse;
use App\Services\Course\Models\VideoComment;
use App\Services\Member\Models\UserWatchStat;
use App\Services\Member\Models\UserVideoWatchRecord;

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
        $course = factory(Course::class)->create([
            'is_show' => Course::SHOW_YES,
            'published_at' => Carbon::now()->subDays(1),
        ]);
        $video = factory(Video::class)->create([
            'course_id' => $course->id,
            'is_show' => Video::IS_SHOW_YES,
            'published_at' => Carbon::now()->subDays(1),
        ]);
        $r = $this->getJson('api/v2/video/' . $video->id);
        $r = $this->assertResponseSuccess($r);
    }

    public function test_video_detail_free_watch()
    {
        $user = factory(User::class)->create();

        $course = factory(Course::class)->create([
            'is_show' => Course::SHOW_YES,
            'published_at' => Carbon::now()->subDays(1),
        ]);
        $video = factory(Video::class)->create([
            'course_id' => $course->id,
            'is_show' => Video::IS_SHOW_YES,
            'published_at' => Carbon::now()->subDays(1),
            'charge' => 0,
        ]);

        $r = $this->user($user)->getJson('api/v2/video/' . $video->id);
        $r = $this->assertResponseSuccess($r);
        $this->assertTrue($r['data']['is_watch']);
    }

    public function test_video_detail_paid()
    {
        $user = factory(User::class)->create();

        $course = factory(Course::class)->create([
            'is_show' => Course::SHOW_YES,
            'published_at' => Carbon::now()->subDays(1),
        ]);
        $video = factory(Video::class)->create([
            'course_id' => $course->id,
            'is_show' => Video::IS_SHOW_YES,
            'published_at' => Carbon::now()->subDays(1),
            'charge' => 99,
        ]);

        UserVideo::create(['video_id' => $video->id, 'user_id' => $user->id]);

        $r = $this->user($user)->getJson('api/v2/video/' . $video->id);
        $r = $this->assertResponseSuccess($r);
        $this->assertTrue($r['data']['is_watch']);
    }

    public function test_video_detail_course_paid()
    {
        $user = factory(User::class)->create();

        $course = factory(Course::class)->create([
            'is_show' => Course::SHOW_YES,
            'published_at' => Carbon::now()->subDays(1),
        ]);
        $video = factory(Video::class)->create([
            'course_id' => $course->id,
            'is_show' => Video::IS_SHOW_YES,
            'published_at' => Carbon::now()->subDays(1),
            'charge' => 100,
        ]);

        UserCourse::create(['user_id' => $user->id, 'course_id' => $course->id]);

        $r = $this->user($user)->getJson('api/v2/video/' . $video->id);
        $r = $this->assertResponseSuccess($r);
        $this->assertTrue($r['data']['is_watch']);
    }

    public function test_video_detail_un_paid()
    {
        $user = factory(User::class)->create();

        $course = factory(Course::class)->create([
            'is_show' => Course::SHOW_YES,
            'published_at' => Carbon::now()->subDays(1),
        ]);
        $video = factory(Video::class)->create([
            'course_id' => $course->id,
            'is_show' => Video::IS_SHOW_YES,
            'published_at' => Carbon::now()->subDays(1),
            'charge' => 100,
        ]);

        $r = $this->user($user)->getJson('api/v2/video/' . $video->id);
        $r = $this->assertResponseSuccess($r);
        $this->assertFalse($r['data']['is_watch']);
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
            'comment_status' => Video::COMMENT_STATUS_ALL,
        ]);
        $r = $this->user($user)->postJson('api/v2/video/' . $video->id . '/comment', [
            'content' => 'hello meedu',
        ]);
        $r = $this->assertResponseSuccess($r);

        $comment = VideoComment::whereUserId($user->id)->whereVideoId($video->id)->first();
        $this->assertNotEmpty($comment);
        $this->assertEquals('hello meedu', $comment->original_content);
    }

    public function test_video_comment_close()
    {
        $user = factory(User::class)->create();

        $video = factory(Video::class)->create([
            'is_show' => Video::IS_SHOW_YES,
            'published_at' => Carbon::now()->subDays(1),
            'comment_status' => Video::COMMENT_STATUS_CLOSE,
        ]);
        $response = $this->user($user)->postJson('api/v2/video/' . $video->id . '/comment', [
            'content' => 'hello meedu',
        ]);
        $this->assertResponseError($response, __('video cant comment'));
    }

    public function test_video_comment_only_paid()
    {
        $user = factory(User::class)->create();

        $video = factory(Video::class)->create([
            'is_show' => Video::IS_SHOW_YES,
            'published_at' => Carbon::now()->subDays(1),
            'comment_status' => Video::COMMENT_STATUS_ONLY_PAID,
        ]);
        $r = $this->user($user)->postJson('api/v2/video/' . $video->id . '/comment', [
            'content' => 'hello meedu',
        ]);
        $this->assertResponseError($r, __('video cant comment'));
    }

    public function test_video_comment_only_paid_for_vip()
    {
        $user = factory(User::class)->create();
        $role = factory(Role::class)->create();
        $user->role_id = $role->id;
        $user->role_expired_at = Carbon::now()->addDays(1);
        $user->save();

        $video = factory(Video::class)->create([
            'is_show' => Video::IS_SHOW_YES,
            'charge' => 1,
            'published_at' => Carbon::now()->subDays(1),
            'comment_status' => Video::COMMENT_STATUS_ONLY_PAID,
        ]);
        $r = $this->user($user)->postJson('api/v2/video/' . $video->id . '/comment', [
            'content' => 'hello meedu',
        ]);
        $this->assertResponseSuccess($r);
    }

    public function test_video_comment_only_paid_for_buy()
    {
        $user = factory(User::class)->create();

        $video = factory(Video::class)->create([
            'is_show' => Video::IS_SHOW_YES,
            'charge' => 1,
            'published_at' => Carbon::now()->subDays(1),
            'comment_status' => Video::COMMENT_STATUS_ONLY_PAID,
        ]);

        UserVideo::create([
            'video_id' => $video->id,
            'user_id' => $user->id,
        ]);

        $r = $this->user($user)->postJson('api/v2/video/' . $video->id . '/comment', [
            'content' => 'hello meedu',
        ]);
        $this->assertResponseSuccess($r);
    }

    public function test_video_comment_only_paid_for_free()
    {
        $user = factory(User::class)->create();

        $video = factory(Video::class)->create([
            'is_show' => Video::IS_SHOW_YES,
            'charge' => 0,
            'published_at' => Carbon::now()->subDays(1),
            'comment_status' => Video::COMMENT_STATUS_ONLY_PAID,
        ]);

        $r = $this->user($user)->postJson('api/v2/video/' . $video->id . '/comment', [
            'content' => 'hello meedu',
        ]);
        $this->assertResponseSuccess($r);
    }

    public function test_video_comment_only_paid_for_buy_course()
    {
        $user = factory(User::class)->create();

        $video = factory(Video::class)->create([
            'is_show' => Video::IS_SHOW_YES,
            'charge' => 0,
            'published_at' => Carbon::now()->subDays(1),
            'comment_status' => Video::COMMENT_STATUS_ONLY_PAID,
        ]);

        UserCourse::create(['course_id' => $video->course_id, 'user_id' => $user->id]);

        $r = $this->user($user)->postJson('api/v2/video/' . $video->id . '/comment', [
            'content' => 'hello meedu',
        ]);
        $this->assertResponseSuccess($r);
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

    public function test_video_record()
    {
        $user = factory(User::class)->create();

        $video = factory(Video::class)->create([
            'is_show' => Video::IS_SHOW_YES,
            'published_at' => Carbon::now()->subDays(1),
            'duration' => 100,
        ]);
        $r = $this->user($user)->postJson('api/v2/video/' . $video->id . '/record', [
            'duration' => 10,
        ]);
        $r = $this->assertResponseSuccess($r);

        $record = UserVideoWatchRecord::query()->where('user_id', $user->id)->where('video_id', $video->id)->first();
        $this->assertNotNull($record);
        $this->assertEquals(10, $record->watch_seconds);

        $r = $this->user($user)->postJson('api/v2/video/' . $video->id . '/record', [
            'duration' => 80,
        ]);
        $r = $this->assertResponseSuccess($r);

        $record->refresh();
        $this->assertEquals(80, $record->watch_seconds);

        $r = $this->user($user)->postJson('api/v2/video/' . $video->id . '/record', [
            'duration' => 100,
        ]);
        $r = $this->assertResponseSuccess($r);

        $record->refresh();
        $this->assertEquals(100, $record->watch_seconds);
        $this->assertNotNull($record->watched_at);
    }

    public function test_video_record_after_user_watch_stat()
    {
        $user = factory(User::class)->create();
        $video = factory(Video::class)->create([
            'is_show' => Video::IS_SHOW_YES,
            'published_at' => Carbon::now()->subDays(1),
            'duration' => 100,
        ]);

        // 前置判断
        $this->assertFalse(UserWatchStat::query()->where('user_id', $user['id'])->exists());

        // 前置环境
        $cacheKey = sprintf(CacheConstant::USER_VIDEO_WATCH_DURATION['name'], $video['id']);
        Cache::put($cacheKey, 1, 10);

        $this->user($user)->postJson('api/v2/video/' . $video->id . '/record', [
            'duration' => 10,
        ]);

        $record = UserWatchStat::query()->where('user_id', $user['id'])->first();
        $this->assertNotNull($record);
        $this->assertEquals(date('Y'), $record['year']);
        $this->assertEquals(date('m'), $record['month']);
        $this->assertEquals(date('d'), $record['day']);
        $this->assertEquals(9, $record['seconds']);

        $this->user($user)->postJson('api/v2/video/' . $video->id . '/record', [
            'duration' => 67,
        ]);

        $record->refresh();
        $this->assertEquals(66, $record['seconds']);

        // 清空前置配置
        Cache::forget($cacheKey);
    }
}
