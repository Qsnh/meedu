<?php

namespace Tests\Feature\Api\V1;

use App\Models\Course;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\OriginalTestCase;

class CourseApiTest extends OriginalTestCase
{

    public function test_course_paginate_api()
    {
        factory(Course::class, 12)->create();
        $response = $this->json('get', '/api/v1/courses');
        $response->assertStatus(200);
    }

    public function test_course_show_normal()
    {
        $course = factory(Course::class)->create([
            'published_at' => Carbon::now(),
            'is_show' => Course::SHOW_YES,
        ]);
        $this->json('get', '/api/v1/course/'.$course->id)
            ->assertStatus(200);
    }

}
