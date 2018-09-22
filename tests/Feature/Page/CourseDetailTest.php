<?php

namespace Tests\Feature\Page;

use App\Models\Course;
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
        $response = $this->get(route('course.show', [$courseShow->id, $courseShow->slug]));
        $response->assertResponseStatus(200);
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

}
