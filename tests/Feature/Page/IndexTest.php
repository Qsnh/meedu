<?php

namespace Tests\Feature\Page;

use App\Models\Course;
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

}
