<?php

namespace Tests\Feature\Page;

use App\Models\Role;
use App\Models\Video;
use App\User;
use Carbon\Carbon;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class RoleBuyTest extends TestCase
{

    public function test_visit_role_buy_page()
    {
        $user = factory(User::class)->create();
        $role = factory(Role::class)->create();
        $this->actingAs($user)
            ->visit(route('member.role.buy', $role))
            ->see($role->name)
            ->see($role->charge)
            ->see($user->credit1);
    }

    public function test_cant_buy_role_insufficient_credit1()
    {
        $user = factory(User::class)->create([
            'credit1' => 0,
        ]);
        $role = factory(Role::class)->create([
            'charge' => mt_rand(1, 100),
        ]);
        $this->actingAs($user)
            ->visit(route('member.role.buy', $role))
            ->seeText('充值');
    }

    public function test_buy_role_success()
    {
        $credit1 = mt_rand(1000, 10000);
        $user = factory(User::class)->create([
            'credit1' => $credit1,
        ]);
        $role = factory(Role::class)->create([
            'charge' => mt_rand(1, 1000),
        ]);
        $this->actingAs($user)
            ->visit(route('member.role.buy', $role))
            ->press('立即购买')
            ->seePageIs(route('member'));
        $user = User::find($user->id);
        $this->actingAs($user)
            ->visit(route('member'))
            ->see($user->role->name)
            ->see($user->role->role_expired_at)
            ->see($credit1 - $role->charge);
        // 存在购买记录
        $this->actingAs($user)
            ->visit(route('member.join_role_records'))
            ->see($role->name)
            ->see($role->charge);
        // 存在订单消费记录
        $this->actingAs($user)
            ->visit(route('member.orders'))
            ->see($role->name)
            ->see($role->charge);
        // 消息通知
        $this->assertTrue($user->unreadNotifications->count() == 1);
    }

    public function test_repeat_buy()
    {
        $credit1 = mt_rand(1000, 10000);
        $user = factory(User::class)->create([
            'credit1' => $credit1,
        ]);
        $role = factory(Role::class)->create([
            'charge' => mt_rand(1, 10),
        ]);
        $this->actingAs($user)
            ->visit(route('member.role.buy', $role))
            ->press('立即购买')
            ->seePageIs(route('member'));
        $user = User::find($user->id);
        $this->actingAs($user)
            ->visit(route('member'))
            ->see($user->role->name)
            ->see($user->role->role_expired_at)
            ->see($credit1 - $role->charge);
        $balance = $user->credit1;
        // 重复购买
        $this->actingAs($user)
            ->visit(route('member.role.buy', $role))
            ->press('立即购买')
            ->seePageIs(route('member'));
        $user = User::find($user->id);
        $this->actingAs($user)
            ->visit(route('member'))
            ->see($user->role->name)
            ->see($user->role->role_expired_at)
            ->see($balance - $role->charge);
    }

}
