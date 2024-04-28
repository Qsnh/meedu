<?php

/*
 * This file is part of the MeEdu.
 *
 * (c) 杭州白书科技有限公司
 */

namespace Tests\Services\Course;

use Carbon\Carbon;
use Tests\TestCase;
use App\Services\Course\Models\Video;
use App\Services\Course\Models\Course;
use App\Services\Course\Models\CourseChapter;
use App\Services\Course\Services\VideoService;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use App\Services\Course\Interfaces\VideoServiceInterface;

class VideoServiceTest extends TestCase
{

    /**
     * @var VideoService
     */
    protected $service;

    public function setUp(): void
    {
        parent::setUp();
        $this->service = $this->app->make(VideoServiceInterface::class);
    }

    public function test_courseVideos_with_no_chapters()
    {
        $videoTotal = random_int(5, 10);
        $course = Course::factory()->create();
        Video::factory()->count($videoTotal)->create([
            'course_id' => $course->id,
            'published_at' => Carbon::now()->subDays(1),
            'is_show' => Video::IS_SHOW_YES,
            'chapter_id' => 0,
        ]);

        $list = $this->service->courseVideos($course['id']);

        $this->assertEquals($videoTotal, count($list[0]));
    }

    public function test_courseVideos_with_no_chapters_with_cache()
    {
        config(['meedu.system.cache.status' => 1]);
        $course = Course::factory()->create();
        Video::factory()->count(10)->create([
            'course_id' => $course->id,
            'published_at' => Carbon::now()->subDays(1),
            'is_show' => Video::IS_SHOW_YES,
            'chapter_id' => 0,
        ]);

        $list = $this->service->courseVideos($course['id']);
        $this->assertEquals(10, count($list[0]));

        Video::factory()->count(2)->create([
            'course_id' => $course->id,
            'published_at' => Carbon::now()->subDays(1),
            'is_show' => Video::IS_SHOW_YES,
            'chapter_id' => 0,
        ]);
        $list = $this->service->courseVideos($course['id']);
        $this->assertEquals(10, count($list[0]));
    }

    public function test_courseVideos_with_chapters()
    {
        $total = [];
        $course = Course::factory()->create();
        $chapters = CourseChapter::factory()->count(random_int(1, 5))->create();
        foreach ($chapters as $chapter) {
            $count = random_int(1, 5);
            Video::factory()->count($count)->create([
                'course_id' => $course->id,
                'published_at' => Carbon::now()->subDays(1),
                'is_show' => Video::IS_SHOW_YES,
                'chapter_id' => $chapter->id,
            ]);
            $total[$chapter->id] = $count;
        }

        $list = $this->service->courseVideos($course['id']);

        foreach ($chapters as $chapter) {
            $this->assertEquals($total[$chapter->id], count($list[$chapter->id]));
        }
    }

    public function test_courseVideos_with_chapters_with_cache()
    {
        config(['meedu.system.cache.status' => 1]);
        config(['meedu.system.cache.expire' => 10]);
        $total = [];
        $course = Course::factory()->create();
        $chapters = CourseChapter::factory()->count(random_int(1, 5))->create();
        foreach ($chapters as $chapter) {
            $count = random_int(1, 5);
            Video::factory()->count($count)->create([
                'course_id' => $course->id,
                'published_at' => Carbon::now()->subDays(1),
                'is_show' => Video::IS_SHOW_YES,
                'chapter_id' => $chapter->id,
            ]);
            $total[$chapter->id] = $count;
        }

        $list = $this->service->courseVideos($course['id']);
        foreach ($chapters as $chapter) {
            $this->assertEquals($total[$chapter->id], count($list[$chapter->id]));
        }

        foreach ($chapters as $chapter) {
            $count = random_int(1, 5);
            Video::factory()->count($count)->create([
                'course_id' => $course->id,
                'published_at' => Carbon::now()->subDays(1),
                'is_show' => Video::IS_SHOW_YES,
                'chapter_id' => $chapter->id,
            ]);
            $total[$chapter->id] = $count;
        }

        $list1 = $this->service->courseVideos($course['id']);
        $this->assertEquals($list, $list1);
    }

    public function test_simplePage()
    {
        $videos = Video::factory()->count(10)->create([
            'is_show' => Video::IS_SHOW_YES,
            'published_at' => Carbon::now()->subDays(1),
        ]);
        $page = $this->service->simplePage(1, 5);
        $this->assertEquals(10, $page['total']);
        $this->assertEquals(5, count($page['list']));
    }

    public function test_find()
    {
        $video = Video::factory()->create([
            'is_show' => Video::IS_SHOW_YES,
            'published_at' => Carbon::now()->subDays(1),
        ]);
        $v = $this->service->find($video->id);
        $this->assertNotEmpty($v);
        $this->assertEquals($video->title, $v['title']);
    }

    public function test_find_with_no_published()
    {
        $this->expectException(ModelNotFoundException::class);

        $video = Video::factory()->create([
            'is_show' => Video::IS_SHOW_YES,
            'published_at' => Carbon::now()->addDays(1),
        ]);
        $this->service->find($video->id);
    }

    public function test_find_with_no_show()
    {
        $this->expectException(ModelNotFoundException::class);

        $video = Video::factory()->create([
            'is_show' => Video::IS_SHOW_NO,
            'published_at' => Carbon::now()->subDays(1),
        ]);
        $this->service->find($video->id);
    }

    public function test_getLatestVideos()
    {
        Video::factory()->count(5)->create([
            'is_show' => Video::IS_SHOW_YES,
            'published_at' => Carbon::now()->subDays(1),
        ]);
        $videos = $this->service->getLatestVideos(3);
        $this->assertNotEmpty(3, count($videos));
    }

    public function test_getLatestVideos_with_cache()
    {
        config(['meedu.system.cache.status' => 1]);
        Video::factory()->count(5)->create([
            'is_show' => Video::IS_SHOW_YES,
            'published_at' => Carbon::now()->subDays(1),
        ]);
        $videos = $this->service->getLatestVideos(10);
        $this->assertNotEmpty(5, count($videos));

        Video::factory()->count(2)->create([
            'is_show' => Video::IS_SHOW_YES,
            'published_at' => Carbon::now()->subDays(1),
        ]);
        $videos = $this->service->getLatestVideos(10);
        $this->assertNotEmpty(5, count($videos));
    }

    public function test_getList()
    {
        $videos = Video::factory()->count(5)->create([
            'is_show' => Video::IS_SHOW_YES,
            'published_at' => Carbon::now()->subDays(1),
        ]);
        $video1 = $videos[0];
        $video2 = $videos[1];
        $list = $this->service->getList([$video1->id, $video2->id]);
        $list = array_column($list, null, 'id');
        $this->assertNotEmpty($list);
        $this->assertTrue(isset($list[$video1->id]));
        $this->assertTrue(isset($list[$video2->id]));
    }

    public function test_viewNumIncrement()
    {
        $video = Video::factory()->create([
            'is_show' => Video::IS_SHOW_YES,
            'published_at' => Carbon::now()->subDays(1),
            'view_num' => 0,
        ]);

        $this->service->viewNumIncrement($video['id'], 13);
        $video->refresh();
        $this->assertEquals(13, $video['view_num']);

        $this->service->viewNumIncrement($video['id'], 20);
        $video->refresh();
        $this->assertEquals(33, $video['view_num']);
    }
}
