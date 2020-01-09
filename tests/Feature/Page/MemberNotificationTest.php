<?php

namespace Tests\Feature\Page;

use App\Services\Member\Models\User;
use Tests\TestCase;

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
