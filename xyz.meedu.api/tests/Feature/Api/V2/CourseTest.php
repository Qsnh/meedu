<?php

/*
 * This file is part of the MeEdu.
 *
 * (c) 杭州白书科技有限公司
 */

namespace Tests\Feature\Api\V2;

use Carbon\Carbon;
use App\Services\Member\Models\Role;
use App\Services\Member\Models\User;
use App\Services\Course\Models\Course;
use App\Services\Member\Models\UserCourse;
use App\Services\Course\Models\CourseComment;
use App\Services\Course\Models\CourseCategory;
use App\Services\Member\Models\UserLikeCourse;

class CourseTest extends Base
{
    public function test_courses()
    {
        $courses = Course::factory()->count(10)->create([
            'is_show' => Course::SHOW_YES,
            'published_at' => Carbon::now()->subDays(1),
        ]);
        $response = $this->get('/api/v2/courses');
        $r = $this->assertResponseSuccess($response);
        $this->assertEquals(10, $r['data']['total']);
    }

    public function test_courses_with_category()
    {
        $category = CourseCategory::factory()->create();
        Course::factory()->count(10)->create([
            'is_show' => Course::SHOW_YES,
            'published_at' => Carbon::now()->subDays(1),
        ]);
        Course::factory()->count(3)->create([
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
        $courses = Course::factory()->count(10)->create([
            'is_show' => Course::SHOW_YES,
            'published_at' => Carbon::now()->subDays(1),
        ]);
        $response = $this->get('/api/v2/courses?page_size=20');
        $r = $this->assertResponseSuccess($response);
        $this->assertEquals(1, $r['data']['last_page']);
    }

    public function test_courses_paginate_page()
    {
        $courses = Course::factory()->count(10)->create([
            'is_show' => Course::SHOW_YES,
            'published_at' => Carbon::now()->subDays(1),
        ]);
        $response = $this->get('/api/v2/courses?page_size=10&page=2');
        $r = $this->assertResponseSuccess($response);
        $this->assertEquals(0, count($r['data']['data']));
    }


    public function test_course_detail()
    {
        $course = Course::factory()->create([
            'published_at' => Carbon::now()->subDays(1),
        ]);
        $response = $this->getJson('/api/v2/course/' . $course->id);
        $this->assertResponseSuccess($response);
    }

    public function test_course_detail_paid()
    {
        $user = User::factory()->create();

        $course = Course::factory()->create([
            'published_at' => Carbon::now()->subDays(1),
        ]);

        UserCourse::create(['course_id' => $course->id, 'user_id' => $user->id, 'charge' => 1]);

        $response = $this->user($user)->getJson('/api/v2/course/' . $course->id);
        $response = $this->assertResponseSuccess($response);
        $this->assertTrue($response['data']['isBuy']);
    }

    public function test_course_id_not_exists()
    {
        $response = $this->getJson('/api/v2/course/123');
        $this->assertResponseError($response, __('错误'));
    }

    public function test_course_id_with_no_published()
    {
        $course = Course::factory()->create([
            'published_at' => Carbon::now()->addDays(1),
        ]);
        $response = $this->getJson('/api/v2/course/' . $course->id);
        $this->assertResponseError($response, __('错误'));
    }

    public function test_course_comment_un_vip()
    {
        $user = User::factory()->create();

        $course = Course::factory()->create([
            'published_at' => Carbon::now()->subDays(1),
        ]);
        $response = $this->user($user)->postJson('api/v2/course/' . $course->id . '/comment', [
            'content' => 'hello meedu',
        ]);
        $this->assertResponseError($response, __('无权限'));
    }

    public function test_course_comment_vip()
    {
        $user = User::factory()->create();
        $role = Role::factory()->create();
        $user->role_id = $role->id;
        $user->role_expired_at = Carbon::now()->addDays(1);
        $user->save();

        $course = Course::factory()->create([
            'published_at' => Carbon::now()->subDays(1),
        ]);
        $response = $this->user($user)->postJson('api/v2/course/' . $course->id . '/comment', [
            'content' => 'hello meedu',
        ]);
        $this->assertResponseSuccess($response);
    }

    public function test_course_comment_paid()
    {
        $user = User::factory()->create();
        $course = Course::factory()->create([
            'published_at' => Carbon::now()->subDays(1),
        ]);

        UserCourse::create([
            'user_id' => $user->id,
            'course_id' => $course->id,
        ]);

        $response = $this->user($user)->postJson('api/v2/course/' . $course->id . '/comment', [
            'content' => 'hello meedu',
        ]);
        $this->assertResponseSuccess($response);
    }

    public function test_course_comments()
    {
        $course = Course::factory()->create([
            'published_at' => Carbon::now()->subDays(1),
        ]);
        CourseComment::factory()->count(10)->create(['course_id' => $course->id]);

        $response = $this->getJson('api/v2/course/' . $course->id . '/comments');
        $r = $this->assertResponseSuccess($response);
        $this->assertEquals(10, count($r['data']['comments']));
    }

    public function test_course_like()
    {
        $user = User::factory()->create();
        $course = Course::factory()->create([
            'published_at' => Carbon::now()->subDays(1),
        ]);
        $response = $this->user($user)->getJson('api/v2/course/' . $course->id . '/like');
        $response = $this->assertResponseSuccess($response);
        $this->assertEquals(1, $response['data']);

        $this->assertTrue(UserLikeCourse::query()->where('user_id', $user->id)->where('course_id', $course->id)->exists());
    }
}
