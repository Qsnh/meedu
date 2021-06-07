<?php

/*
 * This file is part of the Qsnh/meedu.
 *
 * (c) XiaoTeng <616896861@qq.com>
 */

namespace Tests\Feature\Page;

use Carbon\Carbon;
use Tests\TestCase;
use App\Services\Member\Models\Role;
use App\Services\Member\Models\User;
use App\Services\Order\Models\PromoCode;

class MemberInviteCodePageTest extends TestCase
{
    public function test_member_promo_code()
    {
        $user = factory(User::class)->create();
        $this->actingAs($user)
            ->visit(route('member.promo_code'))
            ->assertResponseStatus(200);
    }

    public function test_member_promo_code_with_disabled_free_user()
    {
        $user = factory(User::class)->create();

        config(['meedu.member.invite.free_user_enabled' => false]);

        $this->actingAs($user)
            ->visit(route('member.promo_code'))
            ->assertResponseStatus(200)
            ->seeText(__('无权限'));
    }

    public function test_member_promo_code_with_enabled_free_user()
    {
        $user = factory(User::class)->create();

        config(['meedu.member.invite.free_user_enabled' => true]);

        $this->actingAs($user)
            ->visit(route('member.promo_code'))
            ->assertResponseStatus(200);

        $promoCode = PromoCode::query()->where('user_id', $user['id'])->first();

        $this->actingAs($user)
            ->visit(route('member.promo_code'))
            ->assertResponseStatus(200)
            ->seeText($promoCode['code']);
    }

    public function test_member_promo_code_with_disabled_free_user_and_vip()
    {
        $user = factory(User::class)->create();
        $role = factory(Role::class)->create();

        $user['role_id'] = $role['id'];
        $user['role_expired_at'] = Carbon::now()->addDays(1);
        $user->save();

        config(['meedu.member.invite.free_user_enabled' => true]);

        $this->actingAs($user)
            ->visit(route('member.promo_code'))
            ->assertResponseStatus(200);

        $promoCode = PromoCode::query()->where('user_id', $user['id'])->first();

        $this->actingAs($user)
            ->visit(route('member.promo_code'))
            ->assertResponseStatus(200)
            ->seeText($promoCode['code']);
    }

    public function test_member_promo_with_invite_user()
    {
        $user = factory(User::class)->create();
        factory(User::class, 12)->create(['invite_user_id' => $user->id]);

        config(['meedu.member.invite.free_user_enabled' => true]);

        $this->actingAs($user)
            ->visit(route('member.promo_code'))
            ->assertResponseStatus(200)
            ->seeElement('.pagination');
    }
}
