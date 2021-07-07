<?php

/*
 * This file is part of the Qsnh/meedu.
 *
 * (c) 杭州白书科技有限公司
 */

namespace Tests\Feature\Page;

use Carbon\Carbon;
use Tests\TestCase;
use App\Services\Member\Models\User;
use App\Services\Course\Models\Course;
use App\Services\Member\Models\UserCourse;

class CourseBuyTest extends TestCase
{
    public function test_member_orders_page()
    {
        $user = factory(User::class)->create();
        $course = factory(Course::class)->create([
            'is_show' => Course::SHOW_YES,
            'published_at' => Carbon::now()->subDays(1),
        ]);
        $this->actingAs($user)
            ->visit(route('member.course.buy', [$course->id]))
            ->see($course->title);
    }

    public function test_member_orders_page_with_no_published()
    {
        $this->expectException(\Laravel\BrowserKitTesting\HttpException::class);

        $user = factory(User::class)->create();
        $course = factory(Course::class)->create([
            'is_show' => Course::SHOW_YES,
            'published_at' => Carbon::now()->addDays(1),
        ]);
        $this->actingAs($user)
            ->visit(route('member.course.buy', [$course->id]))
            ->see($course->title);
    }

    public function test_member_orders_page_with_repeat_buy()
    {
        $user = factory(User::class)->create();
        $course = factory(Course::class)->create([
            'is_show' => Course::SHOW_YES,
            'published_at' => Carbon::now()->subDays(1),
        ]);
        UserCourse::create([
            'user_id' => $user->id,
            'course_id' => $course->id,
            'charge' => 1,
            'created_at' => Carbon::now(),
        ]);
        $this->actingAs($user)
            ->visit(route('member.course.buy', [$course->id]));
    }
}
