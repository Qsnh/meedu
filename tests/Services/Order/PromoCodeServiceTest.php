<?php

/*
 * This file is part of the Qsnh/meedu.
 *
 * (c) 杭州白书科技有限公司
 */

namespace Tests\Services\Order;

use Tests\TestCase;
use App\Services\Member\Models\User;
use App\Services\Order\Models\PromoCode;
use App\Services\Order\Models\OrderPaidRecord;
use App\Services\Order\Services\PromoCodeService;

class PromoCodeServiceTest extends TestCase
{

    /**
     * @var PromoCodeService
     */
    protected $service;

    public function setUp(): void
    {
        parent::setUp();

        $this->service = $this->app->make(PromoCodeService::class);
    }

    public function test_userCreate()
    {
        $user = User::factory()->create();
        $this->service->userCreate($user->toArray());

        $this->assertNotEmpty(PromoCode::query()->where('user_id', $user->id)->first());
    }

    public function test_userPromoCode()
    {
        $user = User::factory()->create();
        $this->service->userCreate($user->toArray());

        $this->assertNotEmpty($this->service->userPromoCode($user['id']));
    }

    public function test_findCode()
    {
        $promoCode = PromoCode::factory()->create();
        $this->assertNotEmpty($this->service->findCode($promoCode['code']));
    }

    public function test_getList()
    {
        $promoCode = PromoCode::factory()->create();
        $this->assertNotEmpty($this->service->getList([$promoCode['id']]));
    }

    public function test_decrementUsedTimes()
    {
        $promoCode = PromoCode::factory()->create([
            'used_times' => 2,
        ]);
        $this->service->decrementUsedTimes([$promoCode['id']]);
        $promoCode->refresh();
        $this->assertEquals(1, $promoCode->used_times);
    }

    public function test_getOrderPaidRecords()
    {
        OrderPaidRecord::factory()->count(3)->create([
            'order_id' => 1,
            'paid_type' => OrderPaidRecord::PAID_TYPE_PROMO_CODE,
        ]);
        OrderPaidRecord::factory()->count(2)->create([
            'order_id' => 1,
            'paid_type' => OrderPaidRecord::PAID_TYPE_DEFAULT,
        ]);
        OrderPaidRecord::factory()->count(3)->create([
            'order_id' => 1,
            'paid_type' => OrderPaidRecord::PAID_TYPE_INVITE_BALANCE,
        ]);

        $list = $this->service->getOrderPaidRecords(1);
        $this->assertNotEmpty($list);
        $this->assertEquals(3, count($list));
    }

    public function test_getCurrentUserOrderPaidRecords()
    {
        $user = User::factory()->create();
        $promoCode = PromoCode::factory()->create([
            'used_times' => 2,
        ]);

        OrderPaidRecord::factory()->create([
            'user_id' => $user->id,
            'order_id' => 1,
            'paid_type' => OrderPaidRecord::PAID_TYPE_PROMO_CODE,
            'paid_type_id' => $promoCode['id'],
        ]);

        $list = $this->service->getCurrentUserOrderPaidRecords($user['id'], $promoCode['id']);
        $this->assertNotEmpty($list);
    }
}
