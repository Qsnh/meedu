<?php

namespace Tests\Feature\Page;

use App\Services\Member\Models\User;
use Tests\TestCase;

class MemberAvatarTest extends TestCase
{

    public function test_member_avatar_page()
    {
        $user = factory(User::class)->create();
        $this->actingAs($user)
            ->visit(route('member.avatar'))
            ->see('头像');
    }

    public function test_avatar_change_action()
    {
        $user = factory(User::class)->create();
        $this->actingAs($user)
            ->visit(route('member.avatar'))
            ->attach(base_path('/public/images/meedu.png'), 'file')
            ->press('更换头像')
            ->seePageIs(route('member.avatar'));
    }

}
