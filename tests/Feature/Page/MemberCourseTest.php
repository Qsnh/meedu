<?php

namespace Tests\Feature\Page;

use App\Models\Course;
use App\User;
use Carbon\Carbon;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class MemberCourseTest extends TestCase
{

    public function test_member_course()
    {
        $user = factory(User::class)->create();
        $this->actingAs($user)
            ->visit(route('member.courses'))
            ->see('暂无数据');
    }

    public function test_member_course_see_some_records()
    {
        $course = factory(Course::class)->create();
        $user = factory(User::class)->create();
        $charge = mt_rand(1, 100);
        $user->joinCourses()->attach($course, [
            'charge' => $charge,
            'created_at' => Carbon::now(),
        ]);
        $this->actingAs($user)
            ->visit(route('member.courses'))
            ->see($course->title)
            ->see($charge);
    }

}
