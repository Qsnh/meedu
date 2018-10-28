<?php

namespace Tests\Feature\Page;

use App\User;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class MemberOrdersTest extends TestCase
{

    public function test_member_orders_page()
    {
        $user = factory(User::class)->create();
        $this->actingAs($user)
            ->visit(route('member.orders'))
            ->see('暂无数据');
    }

}
