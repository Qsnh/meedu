<?php

/*
 * This file is part of the Qsnh/meedu.
 *
 * (c) XiaoTeng <616896861@qq.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace Tests\Feature\Page;

use Carbon\Carbon;
use Tests\TestCase;
use App\Services\Course\Models\Video;
use App\Services\Course\Models\Course;
use App\Services\Course\Models\CourseChapter;

class CourseDetailTest extends TestCase
{

    // 创建一个课程，发布时间为前一天，配置为显示
    // 断言这个课程是可以访问的
    public function test_visit_course_detail_page()
    {
        $courseShow = factory(Course::class)->create([
            'title' => '我是课程名',
            'is_show' => Course::SHOW_YES,
            'published_at' => Carbon::now()->subDay(1),
        ]);
        $this->get(route('course.show', [$courseShow->id, $courseShow->slug]))
            ->seeText($courseShow->title)
            ->seeText($courseShow->charge);
    }

    // 创建一个课程，发布时间为前一天，但是不显示
    // 断言这个课程是无法访问的
    public function test_course_show_no()
    {
        $courseNoShow = factory(Course::class)->create([
            'is_show' => Course::SHOW_NO,
            'published_at' => Carbon::now()->subDay(1),
        ]);
        $response = $this->get(route('course.show', [$courseNoShow->id, $courseNoShow->slug]));
        $response->assertResponseStatus(404);
    }

    // 创建课程可以显示，但是时间在明天
    // 这种情况下课程是无法访问的
    public function test_course_no_published_show()
    {
        $courseNoPublished = factory(Course::class)->create([
            'is_show' => Course::SHOW_YES,
            'published_at' => Carbon::now()->addDays(1),
        ]);
        $response = $this->get(route('course.show', [$courseNoPublished->id, $courseNoPublished->slug]));
        $response->assertResponseStatus(404);
    }

    // 创建课程，并在该课程下创建视频
    // 断言是可以看到该课程下的视频的
    public function test_see_course_videos_no_chapter()
    {
        $course = factory(Course::class)->create([
            'is_show' => Course::SHOW_YES,
            'published_at' => Carbon::now()->subMinutes(1),
        ]);
        $video = factory(Video::class)->create([
            'course_id' => $course->id,
            'is_show' => Video::IS_SHOW_YES,
            'published_at' => Carbon::now()->subDay(1),
            'chapter_id' => 0,
        ]);
        $this->visit(route('course.show', [$course->id, $course->slug]))
            ->see($video->title);
    }

    // 创建课程，创建了课程的章节，创建了该章节的视频
    // 访问课程界面可以看到该章节和视频
    public function test_see_course_videos_with_chapter()
    {
        $course = factory(Course::class)->create([
            'is_show' => Course::SHOW_YES,
            'published_at' => Carbon::now()->subMinutes(1),
        ]);
        $chapter = factory(CourseChapter::class)->create([
            'course_id' => $course->id,
        ]);
        $video = factory(Video::class)->create([
            'course_id' => $course->id,
            'is_show' => Video::IS_SHOW_YES,
            'published_at' => Carbon::now()->subDay(1),
            'chapter_id' => $chapter->id,
        ]);
        $this->visit(route('course.show', [$course->id, $course->slug]))
            ->see($chapter->title)
            ->see($video->title);
    }

    // 创建课程并添加视频，但是视频不显示
    // 这种情况下是无法再改课程界面看到不显示的视频的
    public function test_dont_see_no_show_course_videos()
    {
        $video = factory(Video::class)->create([
            'is_show' => Video::IS_SHOW_NO,
            'published_at' => Carbon::now()->subDay(1),
        ]);
        $this->visit(route('course.show', [$video->course->id, $video->course->slug]))
            ->dontSee($video->title);
    }

    // 创建课程并添加视频，但是该视频暂未发布
    // 这种情况下是无法在该课程详情页看到未发布的视频的
    public function test_dont_see_no_published_course_videos()
    {
        $video = factory(Video::class)->create([
            'is_show' => Video::IS_SHOW_YES,
            'published_at' => Carbon::now()->addDays(1),
        ]);
        $this->visit(route('course.show', [$video->course->id, $video->course->slug]))
            ->dontSee($video->title);
    }
}
