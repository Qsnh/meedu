<?php

namespace Tests\Feature\Page;

use App\Models\Course;
use App\Models\EmailSubscription;
use App\Models\Role;
use Carbon\Carbon;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class IndexTest extends TestCase
{
    public function test_visit()
    {
        $this->get(url('/'))->assertResponseStatus(200);
    }

    public function test_see_some_roles()
    {
        $role = factory(Role::class)->create();
        $this->visit(url('/'))
            ->see($role->name)
            ->see($role->charge);
    }

    public function test_see_some_courses()
    {
        $course = factory(Course::class)->create([
            'is_show' => Course::SHOW_YES,
            'published_at' => Carbon::now()->subDay(1),
        ]);
        $this->visit(url('/'))
            ->see($course->title);
    }

    public function test_dont_see_not_show_courses()
    {
        $course = factory(Course::class)->create([
            'is_show' => Course::SHOW_NO,
            'published_at' => Carbon::now()->subDay(1),
        ]);
        $this->visit(url('/'))
            ->dontSee($course->title);
    }

    public function test_dont_see_not_published_courses()
    {
        $course = factory(Course::class)->create([
            'is_show' => Course::SHOW_YES,
            'published_at' => Carbon::now()->addDays(1),
        ]);
        $this->visit(url('/'))
            ->dontSee($course->title);
    }

    public function test_subscription_on_email()
    {
        $email = '12345@qq.com';
        $this->visit(url('/'))
            ->type($email, 'email')
            ->press('订阅')
            ->assertResponseStatus(200);
        $this->assertTrue(EmailSubscription::whereEmail($email)->exists());
    }

}
