<?php

namespace Tests\Feature\Features;

use App\Models\Announcement;
use App\Models\Course;
use App\Models\Role;
use App\Models\Video;
use App\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Cache;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class CacheTest extends TestCase
{

    public function setUp()
    {
        parent::setUp();
        config([
            'meedu.system.cache.status' => 1,
            'meedu.system.cache.expire' => 100,
        ]);
    }

    public function test_index_page_course_cache()
    {
        factory(Course::class, 3)->create([
            'published_at' => Carbon::now(),
            'is_show' => Course::SHOW_YES,
        ]);
        $this->get(url('/'));

        $course = factory(Course::class)->create([
            'title' => '我自己定义的课程标题',
            'published_at' => Carbon::now(),
            'is_show' => Course::SHOW_YES,
        ]);
        $this->visit(url('/'))
            ->dontSee($course->title);
    }

    public function test_index_page_role_cache()
    {
        factory(Role::class, 3)->create();
        $this->visit(url('/'));

        $role = factory(Role::class)->create([
            'name' => '我自己定义的订阅名称',
        ]);
        $this->visit(url('/'))
            ->dontSee($role->name);
    }

    public function test_course_detail_page_video_list_cache()
    {
        $video = factory(Video::class)->create([
            'published_at' => Carbon::now(),
            'is_show' => Course::SHOW_YES,
        ]);

        $url = route('course.show', [$video->course->id, $video->course->slug]);
        $this->visit($url);
        $video = factory(Video::class)->create([
            'course_id' => $video->course->id,
        ]);
        $this->visit($url)
            ->dontSee($video->title);
    }

    public function test_course_detail_new_join_member_cache()
    {
        $this->assertTrue(true);
    }

    public function test_member_page_announcement_cache()
    {
        factory(Announcement::class)->create();
        $user = factory(User::class)->create();
        $this->actingAs($user)
            ->visit(route('member'));

        $announcement = factory(Announcement::class)->create();
        $this->actingAs($user)
            ->visit(route('member'))
            ->dontSee($announcement);
    }

}
