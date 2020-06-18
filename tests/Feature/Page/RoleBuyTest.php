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
use App\Services\Member\Models\Role;
use App\Services\Member\Models\User;

class RoleBuyTest extends TestCase
{
    public function test_member_orders_page()
    {
        $user = factory(User::class)->create();
        $role = factory(Role::class)->create([
            'is_show' => Role::IS_SHOW_YES,
        ]);
        $this->actingAs($user)
            ->visit(route('member.role.buy', [$role->id]))
            ->see($role->name);
    }

    public function test_member_orders_page_with_no_show()
    {
        $this->expectException(\Laravel\BrowserKitTesting\HttpException::class);

        $user = factory(User::class)->create();
        $role = factory(Role::class)->create([
            'is_show' => Role::IS_SHOW_NO,
        ]);
        $this->actingAs($user)
            ->visit(route('member.role.buy', [$role->id]))
            ->see($role->name);
    }

    public function test_role_buy_submit()
    {
        config(['meedu.payment.handPay.enabled' => 1]);

        $user = factory(User::class)->create();
        $role = factory(Role::class)->create([
            'is_show' => Role::IS_SHOW_YES,
            'charge' => 100,
        ]);
        $this->actingAs($user)
            ->visit(route('member.role.buy', [$role->id]))
            ->type($role->id, 'goods_id')
            ->type('pc', 'payment_scene')
            ->type('handPay', 'payment_sign')
            ->press('确认支付')
            ->see('手动');
    }
}
