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
use App\Events\OrderCancelEvent;
use App\Services\Member\Models\Role;
use App\Services\Member\Models\User;
use App\Services\Order\Models\PromoCode;
use App\Services\Order\Services\OrderService;

class OrderCancelEventTest extends TestCase
{
    public function test_PromoCodeResumeListener()
    {
        $user = factory(User::class)->create();
        $promoCode = factory(PromoCode::class)->create([
            'used_times' => 1,
        ]);
        $orderService = $this->app->make(OrderService::class);
        $role = factory(Role::class)->create(['charge' => 100]);
        $order = $orderService->createRoleOrder($user->id, $role->toArray(), $promoCode->id);

        event(new OrderCancelEvent($order['id']));

        $promoCode->refresh();
        $this->assertEquals(1, $promoCode->used_times);
    }
}
