<?php


namespace Tests\Services\Course;

use App\Services\Course\Interfaces\VideoServiceInterface;
use App\Services\Course\Models\Course;
use App\Services\Course\Models\CourseChapter;
use App\Services\Course\Models\Video;
use App\Services\Course\Services\VideoService;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Tests\TestCase;

class VideoServiceTest extends TestCase
{

    /**
     * @var VideoService
     */
    protected $service;

    public function setUp()
    {
        parent::setUp();
        $this->service = $this->app->make(VideoServiceInterface::class);
    }

    public function test_courseVideos_with_no_chapters()
    {
        $videoTotal = mt_rand(5, 10);
        /**
         * @var $videoService VideoService
         */
        $videoService = $this->app->make(VideoService::class);
        $course = factory(Course::class)->create();
        $videos = factory(Video::class, $videoTotal)->create([
            'course_id' => $course->id,
            'published_at' => Carbon::now()->subDays(1),
            'is_show' => Video::IS_SHOW_YES,
            'chapter_id' => 0,
        ]);

        $list = $videoService->courseVideos($course['id']);

        $this->assertEquals($videoTotal, count($list[0]));
    }

    public function test_courseVideos_with_chapters()
    {
        $total = [];
        /**
         * @var $videoService VideoService
         */
        $videoService = $this->app->make(VideoService::class);
        $course = factory(Course::class)->create();
        $chapters = factory(CourseChapter::class, mt_rand(1, 5))->create();
        foreach ($chapters as $chapter) {
            $count = mt_rand(1, 5);
            factory(Video::class, $count)->create([
                'course_id' => $course->id,
                'published_at' => Carbon::now()->subDays(1),
                'is_show' => Video::IS_SHOW_YES,
                'chapter_id' => $chapter->id,
            ]);
            $total[$chapter->id] = $count;
        }

        $list = $videoService->courseVideos($course['id']);

        foreach ($chapters as $chapter) {
            $this->assertEquals($total[$chapter->id], count($list[$chapter->id]));
        }
    }

    public function test_simplePage()
    {
        $videos = factory(Video::class, 10)->create([
            'is_show' => Video::IS_SHOW_YES,
            'published_at' => Carbon::now()->subDays(1),
        ]);
        $page = $this->service->simplePage(1, 5);
        $this->assertEquals(10, $page['total']);
        $this->assertEquals(5, count($page['list']));
    }

    public function test_find()
    {
        $video = factory(Video::class)->create([
            'is_show' => Video::IS_SHOW_YES,
            'published_at' => Carbon::now()->subDays(1),
        ]);
        $v = $this->service->find($video->id);
        $this->assertNotEmpty($v);
        $this->assertEquals($video->title, $v['title']);
    }

    /**
     * @expectedException \Illuminate\Database\Eloquent\ModelNotFoundException
     */
    public function test_find_with_no_published()
    {
        $video = factory(Video::class)->create([
            'is_show' => Video::IS_SHOW_YES,
            'published_at' => Carbon::now()->addDays(1),
        ]);
        $this->service->find($video->id);
    }

    /**
     * @expectedException \Illuminate\Database\Eloquent\ModelNotFoundException
     */
    public function test_find_with_no_show()
    {
        $video = factory(Video::class)->create([
            'is_show' => Video::IS_SHOW_NO,
            'published_at' => Carbon::now()->subDays(1),
        ]);
        $this->service->find($video->id);
    }

    public function test_getLatestVideos()
    {
        factory(Video::class, 5)->create([
            'is_show' => Video::IS_SHOW_YES,
            'published_at' => Carbon::now()->subDays(1),
        ]);
        $videos = $this->service->getLatestVideos(3);
        $this->assertNotEmpty(3, count($videos));
    }

    public function test_titleSearch()
    {
        $video = factory(Video::class)->create([
            'title' => '我是meedu',
            'is_show' => Video::IS_SHOW_YES,
            'published_at' => Carbon::now()->subDays(1),
        ]);
        $video1 = factory(Video::class)->create([
            'title' => '我是meedhaha',
            'is_show' => Video::IS_SHOW_YES,
            'published_at' => Carbon::now()->subDays(1),
        ]);

        $v = $this->service->titleSearch('meedu', 1);
        $this->assertNotEmpty($v);
        $this->assertEquals($video->id, $v[0]['id']);
    }

    public function test_getList()
    {
        $videos = factory(Video::class, 5)->create([
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

}