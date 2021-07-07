<?php

/*
 * This file is part of the Qsnh/meedu.
 *
 * (c) 杭州白书科技有限公司
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
