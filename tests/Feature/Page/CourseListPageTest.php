<?php

namespace Tests\Feature\Page;

use App\Models\Course;
use Carbon\Carbon;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class CourseListPageTest extends TestCase
{

    // 可以正常的访问课程列表页面
    public function test_visit_course_list_page()
    {
        $this->get(route('courses'))->assertResponseStatus(200);
    }

    // 显示且已发布的课程可以在课程列表页面看到
    public function test_visit_course_list_show()
    {
        $course = factory(Course::class)->create([
            'is_show' => Course::SHOW_YES,
            'published_at' => Carbon::now()->subDay(1),
        ]);
        $response = $this->get(route('courses'));
        $response->assertResponseStatus(200);
        $response->see($course->title);
    }

    // 不显示的课程无法再课程列表页面看到
    public function test_visit_course_list_hide()
    {
        $course = factory(Course::class)->create([
            'is_show' => Course::SHOW_NO,
            'published_at' => Carbon::now()->subDay(1),
        ]);
        $response = $this->get(route('courses'));
        $response->assertResponseStatus(200);
        $response->dontSee($course->title);
    }

    // 未发布的课程无法再课程列表界面看到
    public function test_visit_course_list_no_published()
    {
        $course = factory(Course::class)->create([
            'is_show' => Course::SHOW_YES,
            'published_at' => Carbon::now()->addDays(1),
        ]);
        $response = $this->get(route('courses'));
        $response->assertResponseStatus(200);
        $response->dontSee($course->title);
    }

    // 可以看到分页组件
    public function test_visit_course_see_pagination()
    {
        config(['meedu.other.course_list_page_size' => 3]);
        factory(Course::class, 15)->create();
        $this->visit(route('courses'))
            ->seeElement('.pagination');
    }

}
