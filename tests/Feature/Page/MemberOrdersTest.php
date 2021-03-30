<?php

/*
 * This file is part of the Qsnh/meedu.
 *
 * (c) XiaoTeng <616896861@qq.com>
 */

namespace Tests\Feature\Page;

use Tests\TestCase;
use App\Services\Member\Models\User;

class MemberOrdersTest extends TestCase
{
    public function test_member_orders_page()
    {
        $user = factory(User::class)->create();
        $this->actingAs($user)
            ->visit(route('member.orders'));
    }
}
