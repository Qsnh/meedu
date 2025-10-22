<?php

/*
 * This file is part of the MeEdu.
 *
 * (c) 杭州白书科技有限公司
 */

namespace Tests\Feature\Api\V2;

use Carbon\Carbon;
use App\Constant\CacheConstant;
use App\Services\Member\Models\User;
use App\Services\Course\Models\Video;
use Illuminate\Support\Facades\Cache;
use App\Services\Course\Models\Course;
use App\Services\Member\Models\UserVideo;
use App\Services\Member\Models\UserCourse;
use App\Services\Member\Models\UserWatchStat;
use App\Services\Member\Models\UserVideoWatchRecord;

class VideoTest extends Base
{
    public function test_videos()
    {
        Video::factory()->count(10)->create([
            'is_show' => Video::IS_SHOW_YES,
            'published_at' => Carbon::now()->subDays(1),
        ]);
        $r = $this->getJson('api/v2/videos');
        $r = $this->assertResponseSuccess($r);
        $this->assertEquals(10, $r['data']['total']);
    }

    public function test_video_id()
    {
        $course = Course::factory()->create([
            'is_show' => Course::SHOW_YES,
            'published_at' => Carbon::now()->subDays(1),
        ]);
        $video = Video::factory()->create([
            'course_id' => $course->id,
            'is_show' => Video::IS_SHOW_YES,
            'published_at' => Carbon::now()->subDays(1),
        ]);
        $r = $this->getJson('api/v2/video/' . $video->id);
        $r = $this->assertResponseSuccess($r);
    }

    public function test_video_detail_paid()
    {
        $user = User::factory()->create();

        $course = Course::factory()->create([
            'is_show' => Course::SHOW_YES,
            'published_at' => Carbon::now()->subDays(1),
        ]);
        $video = Video::factory()->create([
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
        $user = User::factory()->create();

        $course = Course::factory()->create([
            'is_show' => Course::SHOW_YES,
            'published_at' => Carbon::now()->subDays(1),
        ]);
        $video = Video::factory()->create([
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
        $user = User::factory()->create();

        $course = Course::factory()->create([
            'is_show' => 1,
            'published_at' => Carbon::now()->subDays(1),
            'charge' => 1,
            'is_vip_free' => 0,
        ]);
        $video = Video::factory()->create([
            'course_id' => $course['id'],
            'is_show' => 1,
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
        $this->assertResponseError($r, __('资源不存在'));
    }

    public function test_video_id_no_show()
    {
        $video = Video::factory()->create([
            'is_show' => Video::IS_SHOW_NO,
            'published_at' => Carbon::now()->subDays(1),
        ]);
        $r = $this->getJson('api/v2/video/' . $video->id);
        $this->assertResponseError($r, __('资源不存在'));
    }

    public function test_video_id_no_published()
    {
        $video = Video::factory()->create([
            'is_show' => Video::IS_SHOW_YES,
            'published_at' => Carbon::now()->addDays(1),
        ]);
        $r = $this->getJson('api/v2/video/' . $video->id);
        $this->assertResponseError($r, __('资源不存在'));
    }

    public function test_video_record()
    {
        $user = User::factory()->create();

        $course = Course::factory()->create([
            'is_show' => Course::SHOW_YES,
            'published_at' => Carbon::now()->subDays(1),
            'is_free' => 1, // 免费课程
        ]);

        $video = Video::factory()->create([
            'course_id' => $course->id,
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

    public function test_video_record_without_permission()
    {
        $user = User::factory()->create();

        $course = Course::factory()->create([
            'is_show' => Course::SHOW_YES,
            'published_at' => Carbon::now()->subDays(1),
            'charge' => 100, // 付费课程
            'is_free' => 0,
        ]);

        $video = Video::factory()->create([
            'course_id' => $course->id,
            'is_show' => Video::IS_SHOW_YES,
            'published_at' => Carbon::now()->subDays(1),
            'duration' => 100,
            'charge' => 50,
            'free_seconds' => 0, // 无试看
        ]);

        // 未购买的用户尝试记录学习进度应该失败
        $r = $this->user($user)->postJson('api/v2/video/' . $video->id . '/record', [
            'duration' => 10,
        ]);
        $this->assertResponseError($r, __('无权限观看此视频'));

        // 验证没有创建观看记录
        $record = UserVideoWatchRecord::query()->where('user_id', $user->id)->where('video_id', $video->id)->first();
        $this->assertNull($record);
    }

    public function test_video_record_with_free_seconds()
    {
        $user = User::factory()->create();

        $course = Course::factory()->create([
            'is_show' => Course::SHOW_YES,
            'published_at' => Carbon::now()->subDays(1),
            'charge' => 100,
            'is_free' => 0,
        ]);

        $video = Video::factory()->create([
            'course_id' => $course->id,
            'is_show' => Video::IS_SHOW_YES,
            'published_at' => Carbon::now()->subDays(1),
            'duration' => 1000,
            'charge' => 50,
            'free_seconds' => 60, // 可试看60秒
        ]);

        // 未购买的用户记录学习进度,但时长超过试看时长
        $r = $this->user($user)->postJson('api/v2/video/' . $video->id . '/record', [
            'duration' => 100, // 尝试记录100秒
        ]);
        $r = $this->assertResponseSuccess($r);

        // 验证只记录了试看时长
        $record = UserVideoWatchRecord::query()->where('user_id', $user->id)->where('video_id', $video->id)->first();
        $this->assertNotNull($record);
        $this->assertEquals(60, $record->watch_seconds); // 应该被限制为60秒
        $this->assertNull($record->watched_at); // 未看完
    }

    public function test_video_record_after_user_watch_stat()
    {
        $user = User::factory()->create();

        $course = Course::factory()->create([
            'is_show' => Course::SHOW_YES,
            'published_at' => Carbon::now()->subDays(1),
            'is_free' => 1, // 免费课程
        ]);

        $video = Video::factory()->create([
            'course_id' => $course['id'],
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
