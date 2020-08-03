<?php

/*
 * This file is part of the Qsnh/meedu.
 *
 * (c) XiaoTeng <616896861@qq.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace Tests\Services\Order;

use Tests\TestCase;
use App\Services\Member\Models\User;
use Illuminate\Support\Facades\Auth;
use App\Services\Order\Models\PromoCode;
use App\Services\Order\Models\OrderPaidRecord;
use App\Services\Order\Services\PromoCodeService;

class PromoCodeServiceTest extends TestCase
{

    /**
     * @var PromoCodeService
     */
    protected $service;

    public function setUp():void
    {
        parent::setUp();

        $this->service = $this->app->make(PromoCodeService::class);
    }

    public function test_userCreate()
    {
        $user = factory(User::class)->create();
        Auth::login($user);
        $this->service->userCreate($user->toArray());

        $this->assertNotEmpty(PromoCode::whereUserId($user->id)->first());
    }

    public function test_userPromoCode()
    {
        $user = factory(User::class)->create();
        Auth::login($user);
        $this->service->userCreate($user->toArray());

        $this->assertNotEmpty($this->service->userPromoCode());
    }

    public function test_findCode()
    {
        $promoCode = factory(PromoCode::class)->create();
        $this->assertNotEmpty($this->service->findCode($promoCode['code']));
    }

    public function test_getList()
    {
        $promoCode = factory(PromoCode::class)->create();
        $this->assertNotEmpty($this->service->getList([$promoCode['id']]));
    }

    public function test_decrementUsedTimes()
    {
        $promoCode = factory(PromoCode::class)->create([
            'used_times' => 2,
        ]);
        $this->service->decrementUsedTimes([$promoCode['id']]);
        $promoCode->refresh();
        $this->assertEquals(1, $promoCode->used_times);
    }

    public function test_getOrderPaidRecords()
    {
        factory(OrderPaidRecord::class, 3)->create([
            'order_id' => 1,
            'paid_type' => OrderPaidRecord::PAID_TYPE_PROMO_CODE,
        ]);
        factory(OrderPaidRecord::class, 2)->create([
            'order_id' => 1,
            'paid_type' => OrderPaidRecord::PAID_TYPE_DEFAULT,
        ]);
        factory(OrderPaidRecord::class, 3)->create([
            'order_id' => 1,
            'paid_type' => OrderPaidRecord::PAID_TYPE_INVITE_BALANCE,
        ]);

        $list = $this->service->getOrderPaidRecords(1);
        $this->assertNotEmpty($list);
        $this->assertEquals(3, count($list));
    }

    public function test_getCurrentUserOrderPaidRecords()
    {
        $user = factory(User::class)->create();
        Auth::login($user);
        $promoCode = factory(PromoCode::class)->create([
            'used_times' => 2,
        ]);

        factory(OrderPaidRecord::class)->create([
            'user_id' => $user->id,
            'order_id' => 1,
            'paid_type' => OrderPaidRecord::PAID_TYPE_PROMO_CODE,
            'paid_type_id' => $promoCode['id'],
        ]);

        $list = $this->service->getCurrentUserOrderPaidRecords($promoCode['id']);
        $this->assertNotEmpty($list);
    }
}
