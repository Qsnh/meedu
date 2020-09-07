<?php

/*
 * This file is part of the Qsnh/meedu.
 *
 * (c) XiaoTeng <616896861@qq.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace Tests\Unit\Events;

use Tests\TestCase;
use App\Events\UserRegisterEvent;
use App\Services\Member\Models\User;

class UserRegisterEventTest extends TestCase
{
    public function test_run()
    {
        config(['meedu.member.register.vip.enabled' => 1]);
        config(['meedu.member.register.vip.role_id' => 1]);
        config(['meedu.member.register.vip.days' => 2]);

        $user = factory(User::class)->create(['role_id' => 0]);
        event(new UserRegisterEvent($user->id));

        $user->refresh();

        $this->assertEquals(1, $user->role_id);
    }


    public function test_un_enabled()
    {
        config(['meedu.member.register.vip.enabled' => 0]);
        config(['meedu.member.register.vip.role_id' => 1]);
        config(['meedu.member.register.vip.days' => 2]);

        $user = factory(User::class)->create(['role_id' => 0]);
        event(new UserRegisterEvent($user->id));

        $user->refresh();

        $this->assertEquals(0, $user->role_id);
    }
}
