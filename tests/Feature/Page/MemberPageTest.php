<?php

/*
 * This file is part of the Qsnh/meedu.
 *
 * (c) XiaoTeng <616896861@qq.com>
 */

namespace Tests\Feature\Page;

use Tests\TestCase;
use App\Services\Member\Models\User;

class MemberPageTest extends TestCase
{
    public function test_member_page()
    {
        $user = factory(User::class)->create();
        $this->actingAs($user)
            ->visit(route('member'))
            ->see($user->nick_name);
    }
}
