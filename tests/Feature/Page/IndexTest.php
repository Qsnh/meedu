<?php

namespace Tests\Feature\Page;

use App\Services\Course\Models\Course;
use App\Services\Member\Models\Role;
use App\Services\Other\Models\Link;
use Carbon\Carbon;
use Tests\TestCase;

class IndexTest extends TestCase
{
    // 可以正常访问首页
    public function test_visit()
    {
        $this->get(url('/'))->assertResponseStatus(200);
    }

    // 在首页可以看到已创建的套餐
    public function test_see_some_roles()
    {
        $role = factory(Role::class)->create();
        $this->visit(url('/'))
            ->see($role->name)
            ->see($role->charge);
    }

    // 创建一些显示的且已发布的视频
    // 这种情况在首页是可以看到的
    public function test_see_some_courses()
    {
        $course = factory(Course::class)->create([
            'is_show' => Course::SHOW_YES,
            'published_at' => Carbon::now()->subDay(1),
        ]);
        $this->visit(url('/'))
            ->see($course->title);
    }

    // 在首页无法看到不显示的课程
    public function test_dont_see_not_show_courses()
    {
        $course = factory(Course::class)->create([
            'is_show' => Course::SHOW_NO,
            'published_at' => Carbon::now()->subDay(1),
        ]);
        $this->visit(url('/'))
            ->dontSee($course->title);
    }

    // 在首页无法看到未发布的课程
    public function test_dont_see_not_published_courses()
    {
        $course = factory(Course::class)->create([
            'is_show' => Course::SHOW_YES,
            'published_at' => Carbon::now()->addDays(1),
        ]);
        $this->visit(url('/'))
            ->dontSee($course->title);
    }

    // 在首页可以看到添加的友情链接
    public function test_see_friendlink()
    {
        Link::create([
            'name' => '小滕博客',
            'url' => 'https://58hualong.cn',
        ]);

        $this->visit('/')->see('小滕博客')
            ->see('//58hualong.cn');
    }

}
