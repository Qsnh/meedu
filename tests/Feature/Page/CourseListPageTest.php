<?php

namespace Tests\Feature\Page;

use App\Models\Course;
use Carbon\Carbon;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class CourseListPageTest extends TestCase
{

    public function test_visit_course_list_page()
    {
        $this->get(route('courses'))->assertResponseStatus(200);
    }

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

    public function test_visit_course_list_published()
    {
        $course = factory(Course::class)->create([
            'is_show' => Course::SHOW_YES,
            'published_at' => Carbon::now()->subDay(1),
        ]);
        $response = $this->get(route('courses'));
        $response->assertResponseStatus(200);
        $response->see($course->title);
    }

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

}
