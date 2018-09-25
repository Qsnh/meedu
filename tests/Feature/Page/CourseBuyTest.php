<?php

namespace Tests\Feature\Page;

use App\Models\Course;
use App\User;
use Carbon\Carbon;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class CourseBuyTest extends TestCase
{

    public function test_visit_course_buy()
    {
        $course = factory(Course::class)->create([
            'is_show' => Course::SHOW_YES,
            'published_at' => Carbon::now()->subDays(1),
        ]);
        $user = factory(User::class)->create([
            'credit1' => 100000,
        ]);
        $this->actingAs($user)
            ->visit(route('member.course.buy', $course))
            ->see($course->title)
            ->see($course->charge)
            ->see($user->credit1);
    }

    public function test_visit_insufficient_credit1()
    {
        $course = factory(Course::class)->create([
            'is_show' => Course::SHOW_YES,
            'published_at' => Carbon::now()->subDays(1),
            'charge' => mt_rand(1, 1000),
        ]);
        $user = factory(User::class)->create([
            'credit1' => 0,
        ]);
        $url = route('member.course.buy', $course);
        $this->actingAs($user)
            ->visit($url)
            ->press('立即购买')
            ->seePageIs(route('member.recharge'));
    }

    public function test_course_buy_success()
    {
        $course = factory(Course::class)->create([
            'is_show' => Course::SHOW_YES,
            'published_at' => Carbon::now()->subDays(1),
            'charge' => mt_rand(1, 1000),
        ]);
        $credit1 = 1000000;
        $user = factory(User::class)->create([
            'credit1' => $credit1,
        ]);
        $url = route('member.course.buy', $course);
        // 可以购买
        $this->actingAs($user)
            ->visit($url)
            ->press('立即购买')
            ->seePageIs(route('course.show', [$course->id, $course->slug]));
        $user = User::find($user->id);
        // 消息通知
        $this->assertTrue($user->unreadNotifications->count() > 0);
        // 用户余额减少
        $this->actingAs($user)
            ->visit(route('member'))
            ->see($credit1 - $course->charge);
        // 我的课程界面显示相应记录
        $this->actingAs($user)
            ->visit(route('member.courses'))
            ->see($course->title);
        // 消费记录
        $this->actingAs($user)
            ->visit(route('member.orders'))
            ->see($course->title)
            ->see($course->charge);
    }

}
