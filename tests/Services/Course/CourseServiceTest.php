<?php

/*
 * This file is part of the Qsnh/meedu.
 *
 * (c) XiaoTeng <616896861@qq.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
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
        factory(Course::class, $total)->create([
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
        $category = factory(CourseCategory::class)->create();
        factory(Course::class, $total)->create([
            'published_at' => Carbon::now()->subDays(1),
            'is_show' => Course::SHOW_YES,
        ]);
        factory(Course::class, 2)->create([
            'category_id' => $category->id,
            'published_at' => Carbon::now()->subDays(1),
            'is_show' => Course::SHOW_YES,
        ]);
        $list = $this->courseService->simplePage(1, $pageSize, $category->id);

        $this->assertEquals(2, $list['total']);
    }

    public function test_find()
    {
        $course = factory(Course::class)->create([
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

        $course = factory(Course::class)->create([
            'is_show' => Course::SHOW_YES,
            'published_at' => Carbon::now()->addDays(1),
        ]);
        $c = $this->courseService->find($course->id);
    }

    public function test_find_with_no_show()
    {
        $this->expectException(ModelNotFoundException::class);

        $course = factory(Course::class)->create([
            'is_show' => Course::SHOW_NO,
            'published_at' => Carbon::now()->subDays(1),
        ]);
        $c = $this->courseService->find($course->id);
    }

    public function test_chapters()
    {
        $course = factory(Course::class)->create();
        factory(CourseChapter::class, 10)->create([
            'course_id' => $course->id,
        ]);

        $c = $this->courseService->chapters($course->id);
        $this->assertNotEmpty($c);
        $this->assertEquals(10, count($c));
    }

    public function test_chapters_with_cache()
    {
        config(['meedu.system.cache.status' => 1]);

        $course = factory(Course::class)->create();
        factory(CourseChapter::class, 10)->create([
            'course_id' => $course->id,
        ]);

        $c = $this->courseService->chapters($course->id);
        $this->assertNotEmpty($c);
        $this->assertEquals(10, count($c));

        factory(CourseChapter::class, 2)->create([
            'course_id' => $course->id,
        ]);

        $c = $this->courseService->chapters($course->id);
        $this->assertNotEmpty($c);
        $this->assertEquals(10, count($c));
    }

    public function test_getLatestCourses()
    {
        factory(Course::class, 5)->create([
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
        factory(Course::class, 5)->create([
            'is_show' => Course::SHOW_YES,
            'published_at' => Carbon::now()->subDays(1),
        ]);
        $latestCourses = $this->courseService->getLatestCourses(10);
        $this->assertNotEmpty($latestCourses);
        $this->assertEquals(5, count($latestCourses));

        factory(Course::class, 2)->create([
            'is_show' => Course::SHOW_YES,
            'published_at' => Carbon::now()->subDays(1),
        ]);

        $latestCourses = $this->courseService->getLatestCourses(10);
        $this->assertNotEmpty($latestCourses);
        $this->assertEquals(5, count($latestCourses));
    }

    public function test_getList()
    {
        $courses = factory(Course::class, 5)->create([
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
        factory(Course::class, 3)->create([
            'is_show' => Course::SHOW_YES,
            'published_at' => Carbon::now()->subDays(1),
            'title' => '我是哈哈哈PHP',
        ]);
        factory(Course::class, 4)->create([
            'is_show' => Course::SHOW_YES,
            'published_at' => Carbon::now()->subDays(1),
            'title' => 'javascript',
        ]);

        $res = $this->courseService->titleSearch('我是', 20);
        $this->assertEquals(3, count($res));
    }

    public function test_getRecCourses()
    {
        factory(Course::class, 3)->create([
            'is_show' => Course::SHOW_YES,
            'published_at' => Carbon::now()->subDays(1),
            'is_rec' => Course::REC_YES,
        ]);
        factory(Course::class, 4)->create([
            'is_show' => Course::SHOW_YES,
            'published_at' => Carbon::now()->subDays(1),
            'is_rec' => Course::REC_NO,
        ]);
        $res = $this->courseService->getRecCourses(10);
        $this->assertEquals(3, count($res));
    }

    public function test_createCourseUserRecord()
    {
        $user = factory(User::class)->create();
        $course = factory(Course::class)->create();
        $this->courseService->createCourseUserRecord($user->id, $course->id);
        $this->assertTrue(CourseUserRecord::query()->where('user_id', $user->id)->where('course_id', $course->id)->exists());
        $course->refresh();
        $this->courseService->createCourseUserRecord($user->id, $course->id);
        // 不会重复记录
        $course->refresh();
    }
}
