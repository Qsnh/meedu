<?php


namespace Tests\Feature\Page;


use App\Services\Member\Models\User;
use App\Services\Member\Models\UserInviteBalanceWithdrawOrder;
use Tests\TestCase;

class MemberInviteBalanceWithdrawOrdersPage extends TestCase
{

    public function test_visit()
    {
        $user = factory(User::class)->create([
            'invite_balance' => 100,
        ]);
        factory(UserInviteBalanceWithdrawOrder::class, 20)->create([
            'user_id' => $user->id,
        ]);
        $this->actingAs($user)
            ->visit(route('member.invite_balance_withdraw_orders'))
            ->seeStatusCode(200)
            ->seeElement('.pagination')
            ->see('￥100');
    }

    public function test_submit()
    {
        $user = factory(User::class)->create([
            'invite_balance' => 100,
        ]);
        $this->actingAs($user)->visit(route('member.invite_balance_withdraw_orders'))
            ->type(10, 'total')
            ->type('支付宝', 'channel[name]')
            ->type('姓名', 'channel[username]')
            ->type('账号', 'channel[account]')
            ->press('确认提现')
            ->seeRouteIs('member.invite_balance_withdraw_orders');

        $order = UserInviteBalanceWithdrawOrder::whereUserId($user->id)->first();
        $this->assertNotEmpty($order);
        $this->assertEquals(10, $order->total);
        $this->assertEquals('支付宝', $order->channel);
        $this->assertEquals('姓名', $order->channel_name);
        $this->assertEquals('账号', $order->channel_account);
    }

    public function test_submit_with_insufficient()
    {
        $user = factory(User::class)->create([
            'invite_balance' => 100,
        ]);
        $this->actingAs($user)->visit(route('member.invite_balance_withdraw_orders'))
            ->type(101, 'total')
            ->type('支付宝', 'channel[name]')
            ->type('姓名', 'channel[username]')
            ->type('账号', 'channel[account]')
            ->press('确认提现')
            ->see('flashWarning');
    }

}