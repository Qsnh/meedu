<?php


namespace Tests\Feature\Page;


use App\Services\Course\Models\Course;
use App\Services\Member\Models\User;
use Carbon\Carbon;
use Tests\TestCase;

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

    /**
     * @expectedException \Laravel\BrowserKitTesting\HttpException
     */
    public function test_member_orders_page_with_no_show()
    {
        $user = factory(User::class)->create();
        $course = factory(Course::class)->create([
            'is_show' => Course::SHOW_NO,
            'published_at' => Carbon::now()->subDays(1),
        ]);
        $this->actingAs($user)
            ->visit(route('member.course.buy', [$course->id]))
            ->see($course->title);
    }

    /**
     * @expectedException \Laravel\BrowserKitTesting\HttpException
     */
    public function test_member_orders_page_with_no_published()
    {
        $user = factory(User::class)->create();
        $course = factory(Course::class)->create([
            'is_show' => Course::SHOW_YES,
            'published_at' => Carbon::now()->addDays(1),
        ]);
        $this->actingAs($user)
            ->visit(route('member.course.buy', [$course->id]))
            ->see($course->title);
    }

}