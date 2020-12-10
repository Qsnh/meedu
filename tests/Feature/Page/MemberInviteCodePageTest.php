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
use App\Services\Member\Models\User;
use App\Services\Order\Models\PromoCode;

class MemberInviteCodePageTest extends TestCase
{
    public function test_member_promo_code()
    {
        $user = factory(User::class)->create();
        $this->actingAs($user)
            ->visit(route('member.promo_code'))
            ->assertResponseStatus(200)
            ->see('生成我的专属邀请码');
    }

    public function test_member_promo_code_submit()
    {
        $user = factory(User::class)->create([
            'role_id' => 1,
            'role_expired_at' => Carbon::now()->addDays(1),
        ]);
        $this->actingAs($user)
            ->visit(route('member.promo_code'))
            ->press('生成我的专属邀请码')
            ->see('使用该邀请码的用户将获得');
    }

    public function test_member_promo_code_submit_with_free_user()
    {
        config(['meedu.member.invite.free_user_enabled' => 0]);
        $user = factory(User::class)->create([
            'role_id' => 0,
        ]);
        $this->actingAs($user)
            ->visit(route('member.promo_code'))
            ->press('生成我的专属邀请码')
            ->see('生成我的专属邀请码');

        config(['meedu.member.invite.free_user_enabled' => 1]);
        $this->actingAs($user)
            ->visit(route('member.promo_code'))
            ->press('生成我的专属邀请码')
            ->see('使用该邀请码的用户将获得');
    }

    public function test_member_promo_code_with_exists_promo_code()
    {
        $user = factory(User::class)->create();
        $promoCode = factory(PromoCode::class)->create(['user_id' => $user->id]);
        $this->actingAs($user)
            ->visit(route('member.promo_code'))
            ->assertResponseStatus(200)
            ->see($promoCode['code']);
    }

    public function test_member_promo_with_invite_user()
    {
        $user = factory(User::class)->create();
        factory(User::class, 12)->create(['invite_user_id' => $user->id]);
        $this->actingAs($user)
            ->visit(route('member.promo_code'))
            ->assertResponseStatus(200)
            ->seeElement('.pagination');
    }
}
