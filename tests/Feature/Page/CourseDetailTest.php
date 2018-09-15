<?php

namespace Tests\Feature\Page;

use App\Models\Course;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class CourseDetailTest extends TestCase
{

    public function test_visit_course_detail_page()
    {
        $courseShow = factory(Course::class)->create([
            'is_show' => Course::SHOW_YES,
            'published_at' => date('Y-m-d H:i:s', time() - 100),
        ]);
        $response = $this->get(route('course.show', [$courseShow->id, $courseShow->slug]));
        $response->assertStatus(200);
    }

    public function test_course_show_no()
    {
        $courseNoShow = factory(Course::class)->create([
            'is_show' => Course::SHOW_NO,
            'published_at' => date('Y-m-d H:i:s', time() - 100),
        ]);
        $response = $this->get(route('course.show', [$courseNoShow->id, $courseNoShow->slug]));
        $response->assertStatus(404);
    }

    public function test_course_no_published_show()
    {
        $courseNoPublished = factory(Course::class)->create([
            'is_show' => Course::SHOW_YES,
            'published_at' => date('Y-m-d H:i:s', time() + 1000),
        ]);
        $response = $this->get(route('course.show', [$courseNoPublished->id, $courseNoPublished->slug]));
        $response->assertStatus(404);
    }

    public function test_course_published_show()
    {
        $coursePublished = factory(Course::class)->create([
            'is_show' => Course::SHOW_YES,
            'published_at' => date('Y-m-d H:i:s', time() - 1000),
        ]);
        $response = $this->get(route('course.show', [$coursePublished->id, $coursePublished->slug]));
        $response->assertStatus(200);
        $response->assertSeeText($coursePublished->title);
    }

}
