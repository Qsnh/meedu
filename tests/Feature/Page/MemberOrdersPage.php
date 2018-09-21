<?php

namespace Tests\Feature\Page;

use App\Models\Course;
use App\Models\Order;
use App\Models\Role;
use App\Models\Video;
use App\User;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class MemberOrdersPage extends TestCase
{

    public function test_member_orders_page()
    {
        $user = factory(User::class)->create();
        $this->actingAs($user)
            ->visit(route('member.orders'))
            ->see('暂无数据');
    }

    public function test_member_orders_see_course_records()
    {
        $course = factory(Course::class)->create();
        $order = factory(Order::class)->create([
            'goods_type' => Order::GOODS_TYPE_COURSE,
            'goods_id' => $course->id,
        ]);
        $this->actingAs($order->user)
            ->visit(route('member.orders'))
            ->see($order->charge)
            ->see($order->getGoodsTypeText());
    }

    public function test_member_orders_see_role_records()
    {
        $role = factory(Role::class)->create();
        $order = factory(Order::class)->create([
            'goods_type' => Order::GOODS_TYPE_ROLE,
            'goods_id' => $role->id,
        ]);
        $this->actingAs($order->user)
            ->visit(route('member.orders'))
            ->see($order->charge)
            ->see($order->getGoodsTypeText());
    }

    public function test_member_orders_see_video_records()
    {
        $video = factory(Video::class)->create();
        $order = factory(Order::class)->create([
            'goods_type' => Order::GOODS_TYPE_VIDEO,
            'goods_id' => $video->id,
        ]);
        $this->actingAs($order->user)
            ->visit(route('member.orders'))
            ->see($order->charge)
            ->see($order->getGoodsTypeText());
    }

}
