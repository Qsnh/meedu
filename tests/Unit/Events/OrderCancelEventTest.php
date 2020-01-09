<?php


namespace Tests\Unit\Events;


use App\Events\OrderCancelEvent;
use App\Services\Member\Models\Role;
use App\Services\Member\Models\User;
use App\Services\Order\Models\PromoCode;
use App\Services\Order\Services\OrderService;
use Tests\TestCase;

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