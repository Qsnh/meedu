<?php


namespace Tests\Feature\Api\V2;


use App\Services\Course\Models\Course;
use App\Services\Course\Models\CourseCategory;
use App\Services\Course\Models\CourseComment;
use App\Services\Member\Models\User;
use Carbon\Carbon;

class CourseTest extends Base
{

    public function test_courses()
    {
        $courses = factory(Course::class, 10)->create([
            'is_show' => Course::SHOW_YES,
            'published_at' => Carbon::now()->subDays(1),
        ]);
        $response = $this->get('/api/v2/courses');
        $r = $this->assertResponseSuccess($response);
        $this->assertEquals(10, $r['data']['total']);
    }

    public function test_courses_with_category()
    {
        $category = factory(CourseCategory::class)->create();
        factory(Course::class, 10)->create([
            'is_show' => Course::SHOW_YES,
            'published_at' => Carbon::now()->subDays(1),
        ]);
        factory(Course::class, 3)->create([
            'category_id' => $category->id,
            'is_show' => Course::SHOW_YES,
            'published_at' => Carbon::now()->subDays(1),
        ]);
        $response = $this->get('/api/v2/courses?category_id=' . $category->id);
        $r = $this->assertResponseSuccess($response);
        $this->assertEquals(3, $r['data']['total']);
    }

    public function test_courses_paginate_size()
    {
        $courses = factory(Course::class, 10)->create([
            'is_show' => Course::SHOW_YES,
            'published_at' => Carbon::now()->subDays(1),
        ]);
        $response = $this->get('/api/v2/courses?page_size=20');
        $r = $this->assertResponseSuccess($response);
        $this->assertEquals(1, $r['data']['last_page']);
    }

    public function test_courses_paginate_page()
    {
        $courses = factory(Course::class, 10)->create([
            'is_show' => Course::SHOW_YES,
            'published_at' => Carbon::now()->subDays(1),
        ]);
        $response = $this->get('/api/v2/courses?page_size=10&page=2');
        $r = $this->assertResponseSuccess($response);
        $this->assertEquals(0, count($r['data']['data']));
    }


    public function test_course_id()
    {
        $course = factory(Course::class)->create([
            'is_show' => Course::SHOW_YES,
            'published_at' => Carbon::now()->subDays(1),
        ]);
        $response = $this->getJson('/api/v2/course/' . $course->id);
        $this->assertResponseSuccess($response);
    }

    public function test_course_id_not_exists()
    {
        $response = $this->getJson('/api/v2/course/123');
        $this->assertResponseError($response, __('error'));
    }

    public function test_course_id_with_no_show()
    {
        $course = factory(Course::class)->create([
            'is_show' => Course::SHOW_NO,
            'published_at' => Carbon::now()->subDays(1),
        ]);
        $response = $this->getJson('/api/v2/course/' . $course->id);
        $this->assertResponseError($response, __('error'));
    }

    public function test_course_id_with_no_published()
    {
        $course = factory(Course::class)->create([
            'is_show' => Course::SHOW_YES,
            'published_at' => Carbon::now()->addDays(1),
        ]);
        $response = $this->getJson('/api/v2/course/' . $course->id);
        $this->assertResponseError($response, __('error'));
    }

    public function test_course_comment()
    {
        $user = factory(User::class)->create();
        $course = factory(Course::class)->create([
            'is_show' => Course::SHOW_YES,
            'published_at' => Carbon::now()->addDays(1),
        ]);
        $response = $this->user($user)->postJson('api/v2/course/' . $course->id . '/comment', [
            'content' => 'hello meedu',
        ]);
        $this->assertResponseSuccess($response);
        $comment = CourseComment::whereUserId($user->id)->whereCourseId($course->id)->first();
        $this->assertNotEmpty($comment);
        $this->assertEquals('hello meedu', $comment->original_content);
    }

    public function test_course_comments()
    {
        $course = factory(Course::class)->create([
            'is_show' => Course::SHOW_YES,
            'published_at' => Carbon::now()->addDays(1),
        ]);
        factory(CourseComment::class, 10)->create(['course_id' => $course->id]);

        $response = $this->getJson('api/v2/course/' . $course->id . '/comments');
        $r = $this->assertResponseSuccess($response);
        $this->assertEquals(10, count($r['data']['comments']));
    }

}