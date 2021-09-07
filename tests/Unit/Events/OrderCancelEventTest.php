<?php

/*
 * This file is part of the Qsnh/meedu.
 *
 * (c) 杭州白书科技有限公司
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
        $user = User::factory()->create();
        $promoCode = PromoCode::factory()->create([
            'used_times' => 1,
        ]);
        $orderService = $this->app->make(OrderService::class);
        $role = Role::factory()->create(['charge' => 100]);
        $order = $orderService->createRoleOrder($user->id, $role->toArray(), $promoCode->id);

        event(new OrderCancelEvent($order['id']));

        $promoCode->refresh();
        $this->assertEquals(1, $promoCode->used_times);
    }
}
