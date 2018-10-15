<?php

namespace Tests\Feature\Api\V1;

use App\Http\Resources\CourseListResource;
use App\Http\Resources\CourseResource;
use App\Http\Resources\CourseVideoListResource;
use App\Http\Resources\VideoRecourse;
use App\Models\Course;
use App\Models\Video;
use App\User;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Laravel\Passport\Passport;
use Tests\OriginalTestCase;

class CourseApiTest extends OriginalTestCase
{

    public function setUp()
    {
        parent::setUp();

        config([
            'meedu.system.cache.status' => 0,
            'meedu.system.cache.expire' => 100,
        ]);
    }

    public function test_courses_paginate()
    {
        $courses = factory(Course::class, 4)->create([
            'is_show' => Course::SHOW_YES,
            'published_at' => Carbon::now()->subDay(1),
        ]);
        $response = $this->json('GET', '/api/v1/courses');
        $response->assertStatus(200);
        foreach ($courses as $index => $item) {
            $response->assertJsonFragment((new CourseListResource($item))->toArray(request()));
        }
    }

    public function test_course_show()
    {
        $course = factory(Course::class)->create([
            'published_at' => Carbon::now(),
            'is_show' => Course::SHOW_YES,
        ]);
        $this->json('GET', '/api/v1/course/'.$course->id)
            ->assertStatus(200)
            ->assertJson([
                'data' => (new CourseResource($course))->toArray(request()),
            ]);
    }

    public function test_course_no_show()
    {
        $course = factory(Course::class)->create([
            'published_at' => Carbon::now(),
            'is_show' => Course::SHOW_NO,
        ]);
        $this->json('GET', '/api/v1/course/'.$course->id)
            ->assertStatus(200)
            ->assertExactJson([
                'message' => 'No query results for model [App\\Models\\Course].',
                'code' => 500,
            ]);
    }

    public function test_course_no_published()
    {
        $course = factory(Course::class)->create([
            'published_at' => Carbon::now()->addDay(1),
            'is_show' => Course::SHOW_YES,
        ]);
        $this->json('get', '/api/v1/course/'.$course->id)
            ->assertStatus(200)
            ->assertExactJson([
                'message' => 'No query results for model [App\\Models\\Course].',
                'code' => 500,
            ]);
    }

    public function test_course_videos()
    {
        $course = factory(Course::class)->create([
            'is_show' => Course::SHOW_YES,
            'published_at' => Carbon::now()->subDay(1),
        ]);
        $videos = factory(Video::class, 3)->create([
            'is_show' => Video::IS_SHOW_YES,
            'published_at' => Carbon::now()->subDay(1),
            'course_id' => $course->id,
        ]);
        $response = $this->json('GET', '/api/v1/course/'.$course->id.'/videos');
        $response->assertStatus(200);
        foreach ($videos as $video) {
            $response->assertJsonFragment((new CourseVideoListResource($video))->toArray(request()));
        }
    }

    public function test_course_comment()
    {
        $content = '你好，课程123';
        $course = factory(Course::class)->create([
            'is_show' => Course::SHOW_YES,
            'published_at' => Carbon::now()->subDay(1),
        ]);
        Passport::actingAs(factory(User::class)->create());
        $this->json('POST', '/api/v1/course/'.$course->id.'/comment', [
                'content' => $content,
            ])
            ->assertJsonFragment([
                'content' => markdown_to_html($content),
            ]);
    }

}
