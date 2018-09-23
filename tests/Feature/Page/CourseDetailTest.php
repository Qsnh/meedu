<?php

namespace Tests\Feature\Page;

use App\Models\Course;
use App\Models\Video;
use App\User;
use Carbon\Carbon;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class CourseDetailTest extends TestCase
{

    public function test_visit_course_detail_page()
    {
        $courseShow = factory(Course::class)->create([
            'is_show' => Course::SHOW_YES,
            'published_at' => Carbon::now()->subDay(1),
        ]);
        $this->get(route('course.show', [$courseShow->id, $courseShow->slug]))
            ->see($courseShow->title)
            ->see($courseShow->charge);
    }

    public function test_course_show_no()
    {
        $courseNoShow = factory(Course::class)->create([
            'is_show' => Course::SHOW_NO,
            'published_at' => Carbon::now()->subDay(1),
        ]);
        $response = $this->get(route('course.show', [$courseNoShow->id, $courseNoShow->slug]));
        $response->assertResponseStatus(404);
    }

    public function test_course_no_published_show()
    {
        $courseNoPublished = factory(Course::class)->create([
            'is_show' => Course::SHOW_YES,
            'published_at' => Carbon::now()->addDays(1),
        ]);
        $response = $this->get(route('course.show', [$courseNoPublished->id, $courseNoPublished->slug]));
        $response->assertResponseStatus(404);
    }

    public function test_course_published_show()
    {
        $coursePublished = factory(Course::class)->create([
            'is_show' => Course::SHOW_YES,
            'published_at' => Carbon::now()->subDay(1),
        ]);
        $response = $this->get(route('course.show', [$coursePublished->id, $coursePublished->slug]));
        $response->assertResponseStatus(200);
        $response->see($coursePublished->title);
    }

    public function test_see_course_videos()
    {
        $video = factory(Video::class)->create([
            'is_show' => Video::IS_SHOW_YES,
            'published_at' => Carbon::now()->subDay(1),
        ]);
        $this->visit(route('course.show', [$video->course->id, $video->course->slug]))
            ->see($video->title);
    }

    public function test_dont_see_no_show_course_videos()
    {
        $video = factory(Video::class)->create([
            'is_show' => Video::IS_SHOW_NO,
            'published_at' => Carbon::now()->subDay(1),
        ]);
        $this->visit(route('course.show', [$video->course->id, $video->course->slug]))
            ->dontSee($video->title);
    }

    public function test_dont_see_no_published_course_videos()
    {
        $video = factory(Video::class)->create([
            'is_show' => Video::IS_SHOW_YES,
            'published_at' => Carbon::now()->addDays(1),
        ]);
        $this->visit(route('course.show', [$video->course->id, $video->course->slug]))
            ->dontSee($video->title);
    }

    public function test_course_comment()
    {
        $content = '我是评论内容';
        $courseShow = factory(Course::class)->create([
            'is_show' => Course::SHOW_YES,
            'published_at' => Carbon::now()->subDay(1),
        ]);
        $user = factory(User::class)->create();
        $this->actingAs($user)
            ->visit(route('course.show', [$courseShow->id, $courseShow->slug]))
            ->type($content, 'content')
            ->press('提交评论')
            ->see($user->nick_name)
            ->see($user->avatar);
    }

}
