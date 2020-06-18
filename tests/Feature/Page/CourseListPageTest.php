<?php

/*
 * This file is part of the Qsnh/meedu.
 *
 * (c) XiaoTeng <616896861@qq.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace Tests\Feature\Page;

use Carbon\Carbon;
use Tests\TestCase;
use App\Services\Course\Models\Course;
use App\Services\Course\Models\CourseCategory;

class CourseListPageTest extends TestCase
{

    // 可以正常的访问课程列表页面
    public function test_visit_course_list_page()
    {
        $this->get(route('courses'))->assertResponseStatus(200);
    }

    // 显示且已发布的课程可以在课程列表页面看到
    public function test_visit_course_list_show()
    {
        $course = factory(Course::class)->create([
            'is_show' => Course::SHOW_YES,
            'published_at' => Carbon::now()->subDay(1),
        ]);
        $response = $this->get(route('courses'));
        $response->assertResponseStatus(200);
        $response->see($course->title);
    }

    // 不显示的课程无法再课程列表页面看到
    public function test_visit_course_list_hide()
    {
        $course = factory(Course::class)->create([
            'is_show' => Course::SHOW_NO,
            'published_at' => Carbon::now()->subDay(1),
        ]);
        $response = $this->get(route('courses'));
        $response->assertResponseStatus(200);
        $response->dontSee($course->title);
    }

    // 未发布的课程无法再课程列表界面看到
    public function test_visit_course_list_no_published()
    {
        $course = factory(Course::class)->create([
            'is_show' => Course::SHOW_YES,
            'published_at' => Carbon::now()->addDays(1),
        ]);
        $response = $this->get(route('courses'));
        $response->assertResponseStatus(200);
        $response->dontSee($course->title);
    }

    // 可以看到分页组件
    public function test_visit_course_see_pagination()
    {
        // 配置每页显示3个
        config(['meedu.other.course_list_page_size' => 3]);
        // 创建10个
        factory(Course::class, 10)->create([
            'is_show' => Course::SHOW_YES,
            'published_at' => Carbon::now()->subDays(1),
        ]);
        $this->visit(route('courses'))
            ->seeElement('.pagination');
    }

    public function test_visit_course_with_category()
    {
        // 配置每页显示3个
        config(['meedu.other.course_list_page_size' => 3]);
        $category = factory(CourseCategory::class)->create([
            'is_show' => CourseCategory::IS_SHOW_YES,
            'name' => '分类一',
        ]);
        $category1 = factory(CourseCategory::class)->create([
            'is_show' => CourseCategory::IS_SHOW_YES,
            'name' => '分类二',
        ]);
        $c1 = factory(Course::class)->create([
            'is_show' => Course::SHOW_YES,
            'published_at' => Carbon::now()->subDays(1),
            'category_id' => $category->id,
            'title' => '哈哈'
        ]);
        $c2 = factory(Course::class)->create([
            'is_show' => Course::SHOW_YES,
            'published_at' => Carbon::now()->subDays(1),
            'category_id' => $category1->id,
            'title' => '大大',
        ]);
        $this->visit(route('courses'))
            ->see($category->name)
            ->see($category1->name)
            ->click($category->name)
            ->see($c1->title);
    }
}
