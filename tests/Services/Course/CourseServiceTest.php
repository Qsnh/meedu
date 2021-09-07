<?php

/*
 * This file is part of the Qsnh/meedu.
 *
 * (c) 杭州白书科技有限公司
 */

namespace Tests\Services\Course;

use Carbon\Carbon;
use Tests\TestCase;
use App\Services\Member\Models\User;
use App\Services\Course\Models\Course;
use App\Services\Course\Models\CourseChapter;
use App\Services\Course\Models\CourseCategory;
use App\Services\Course\Services\CourseService;
use App\Services\Course\Models\CourseUserRecord;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use App\Services\Course\Interfaces\CourseServiceInterface;

class CourseServiceTest extends TestCase
{

    /**
     * @var CourseService
     */
    protected $courseService;

    public function setUp(): void
    {
        parent::setUp();
        $this->courseService = $this->app->make(CourseServiceInterface::class);
    }

    public function test_simplePage()
    {
        $pageSize = random_int(1, 10);
        $total = random_int(15, 20);
        Course::factory()->count($total)->create([
            'published_at' => Carbon::now()->subDays(1),
            'is_show' => Course::SHOW_YES,
        ]);
        $list = $this->courseService->simplePage(1, $pageSize);

        $this->assertEquals($pageSize, count($list['list']));
        $this->assertEquals($total, $list['total']);
    }

    public function test_simplePage_with_category()
    {
        $pageSize = random_int(1, 10);
        $total = random_int(15, 20);
        $category = CourseCategory::factory()->create();
        Course::factory()->count($total)->create([
            'published_at' => Carbon::now()->subDays(1),
            'is_show' => Course::SHOW_YES,
        ]);
        Course::factory()->count(2)->create([
            'category_id' => $category->id,
            'published_at' => Carbon::now()->subDays(1),
            'is_show' => Course::SHOW_YES,
        ]);
        $list = $this->courseService->simplePage(1, $pageSize, $category->id);

        $this->assertEquals(2, $list['total']);
    }

    public function test_find()
    {
        $course = Course::factory()->create([
            'is_show' => Course::SHOW_YES,
            'published_at' => Carbon::now()->subDays(1),
        ]);
        $c = $this->courseService->find($course->id);

        $this->assertNotEmpty($c);
        $this->assertEquals($course->title, $c['title']);
    }

    public function test_find_with_no_published()
    {
        $this->expectException(ModelNotFoundException::class);

        $course = Course::factory()->create([
            'is_show' => Course::SHOW_YES,
            'published_at' => Carbon::now()->addDays(1),
        ]);
        $c = $this->courseService->find($course->id);
    }

    public function test_chapters()
    {
        $course = Course::factory()->create();
        CourseChapter::factory()->count(10)->create([
            'course_id' => $course->id,
        ]);

        $c = $this->courseService->chapters($course->id);
        $this->assertNotEmpty($c);
        $this->assertEquals(10, count($c));
    }

    public function test_chapters_with_cache()
    {
        config(['meedu.system.cache.status' => 1]);

        $course = Course::factory()->create();
        CourseChapter::factory()->count(10)->create([
            'course_id' => $course->id,
        ]);

        $c = $this->courseService->chapters($course->id);
        $this->assertNotEmpty($c);
        $this->assertEquals(10, count($c));

        CourseChapter::factory()->count(2)->create([
            'course_id' => $course->id,
        ]);

        $c = $this->courseService->chapters($course->id);
        $this->assertNotEmpty($c);
        $this->assertEquals(10, count($c));
    }

    public function test_getLatestCourses()
    {
        Course::factory()->count(5)->create([
            'is_show' => Course::SHOW_YES,
            'published_at' => Carbon::now()->subDays(1),
        ]);
        $latestCourses = $this->courseService->getLatestCourses(3);
        $this->assertNotEmpty($latestCourses);
        $this->assertEquals(3, count($latestCourses));
    }

    public function test_getLatestCourses_withCache()
    {
        config(['meedu.system.cache.status' => 1]);
        Course::factory()->count(5)->create([
            'is_show' => Course::SHOW_YES,
            'published_at' => Carbon::now()->subDays(1),
        ]);
        $latestCourses = $this->courseService->getLatestCourses(10);
        $this->assertNotEmpty($latestCourses);
        $this->assertEquals(5, count($latestCourses));

        Course::factory()->count(2)->create([
            'is_show' => Course::SHOW_YES,
            'published_at' => Carbon::now()->subDays(1),
        ]);

        $latestCourses = $this->courseService->getLatestCourses(10);
        $this->assertNotEmpty($latestCourses);
        $this->assertEquals(5, count($latestCourses));
    }

    public function test_getList()
    {
        $courses = Course::factory()->count(5)->create([
            'is_show' => Course::SHOW_YES,
            'published_at' => Carbon::now()->subDays(1),
        ]);
        $course1 = $courses[0];
        $course2 = $courses[1];
        $latestCourses = $this->courseService->getList([$course1->id, $course2->id]);
        $latestCourses = array_column($latestCourses, null, 'id');
        $this->assertNotEmpty($latestCourses);
        $this->assertTrue(isset($latestCourses[$course1->id]));
        $this->assertTrue(isset($latestCourses[$course2->id]));
    }

    public function test_titleSearch()
    {
        Course::factory()->count(3)->create([
            'is_show' => Course::SHOW_YES,
            'published_at' => Carbon::now()->subDays(1),
            'title' => '我是哈哈哈PHP',
        ]);
        Course::factory()->count(4)->create([
            'is_show' => Course::SHOW_YES,
            'published_at' => Carbon::now()->subDays(1),
            'title' => 'javascript',
        ]);

        $res = $this->courseService->titleSearch('我是', 20);
        $this->assertEquals(3, count($res));
    }

    public function test_getRecCourses()
    {
        Course::factory()->count(3)->create([
            'is_show' => Course::SHOW_YES,
            'published_at' => Carbon::now()->subDays(1),
            'is_rec' => Course::REC_YES,
        ]);
        Course::factory()->count(4)->create([
            'is_show' => Course::SHOW_YES,
            'published_at' => Carbon::now()->subDays(1),
            'is_rec' => Course::REC_NO,
        ]);
        $res = $this->courseService->getRecCourses(10);
        $this->assertEquals(3, count($res));
    }

    public function test_createCourseUserRecord()
    {
        $user = User::factory()->create();
        $course = Course::factory()->create();
        $this->courseService->createCourseUserRecord($user->id, $course->id);
        $this->assertTrue(CourseUserRecord::query()->where('user_id', $user->id)->where('course_id', $course->id)->exists());
        $course->refresh();
        $this->courseService->createCourseUserRecord($user->id, $course->id);
        // 不会重复记录
        $course->refresh();
    }
}
