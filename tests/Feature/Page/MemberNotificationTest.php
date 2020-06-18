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

use Tests\TestCase;
use App\Services\Member\Models\User;

class MemberNotificationTest extends TestCase
{
    public function test_member_notification()
    {
        $user = factory(User::class)->create();
        $this->actingAs($user)
            ->visit(route('member.messages'))
            ->assertResponseStatus(200);
    }
}
