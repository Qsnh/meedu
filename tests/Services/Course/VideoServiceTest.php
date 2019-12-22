<?php


namespace Tests\Services\Course;

use App\Services\Course\Models\Course;
use App\Services\Course\Models\CourseChapter;
use App\Services\Course\Models\Video;
use App\Services\Course\Services\VideoService;
use Carbon\Carbon;
use Tests\TestCase;

class VideoServiceTest extends TestCase
{

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

}