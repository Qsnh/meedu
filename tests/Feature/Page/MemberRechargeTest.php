<?php

namespace Tests\Feature\Page;

use App\Models\RechargePayment;
use App\User;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class MemberRechargeTest extends TestCase
{

    public function test_member_recharge_page()
    {
        $user = factory(User::class)->create();
        $this->actingAs($user)
            ->visit(route('member.recharge_records'))
            ->see('暂无数据');
    }

    public function test_can_see_paid_records()
    {
        $user = factory(User::class)->create();
        $rechargeRecord = $user->rechargePayments()->save(new RechargePayment([
            'money' => mt_rand(0, 1000),
            'status' => RechargePayment::STATUS_PAYED,
            'pay_method' => '支付宝支付',
            'third_id' => mt_rand(0, 10000),
        ]));
        $this->actingAs($user)
            ->visit(route('member.recharge_records'))
            ->see($rechargeRecord->money);
    }

    public function test_dont_see_unpay_records()
    {
        $user = factory(User::class)->create();
        $rechargeRecord = $user->rechargePayments()->save(new RechargePayment([
            'money' => mt_rand(0, 1000),
            'status' => RechargePayment::STATUS_NO_PAY,
            'pay_method' => '支付宝支付',
            'third_id' => mt_rand(0, 10000),
        ]));
        $this->actingAs($user)
            ->visit(route('member.recharge_records'))
            ->dontSee($rechargeRecord->money);
    }


}
