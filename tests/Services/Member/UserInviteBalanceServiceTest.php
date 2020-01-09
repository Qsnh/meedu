<?php


namespace Tests\Services\Member;


use App\Services\Member\Models\User;
use App\Services\Member\Models\UserInviteBalanceRecord;
use App\Services\Member\Services\UserInviteBalanceService;
use App\Services\Order\Models\Order;
use Tests\TestCase;

class UserInviteBalanceServiceTest extends TestCase
{

    /**
     * @var UserInviteBalanceService
     */
    protected $service;

    public function setUp()
    {
        parent::setUp();
        $this->service = $this->app->make(UserInviteBalanceService::class);
    }

    public function test_createInvite()
    {
        $user = factory(User::class)->create();
        $this->service->createInvite($user->id, 10);

        $r = UserInviteBalanceRecord::whereUserId($user->id)->first();
        $this->assertNotEmpty($r);
        $this->assertEquals(10, $r->total);
        $this->assertEquals(UserInviteBalanceRecord::TYPE_DEFAULT, $r->type);
    }

    public function test_createOrderDraw()
    {
        $user = factory(User::class)->create();
        $order = factory(Order::class)->create([
            'user_id' => $user->id,
            'charge' => 100,
        ]);
        $this->service->createOrderDraw($user->id, 10, $order->toArray());

        $r = UserInviteBalanceRecord::whereUserId($user->id)->first();
        $this->assertNotEmpty($r);
        $this->assertEquals(10, $r->total);
        $this->assertEquals(UserInviteBalanceRecord::TYPE_ORDER_DRAW, $r->type);
    }

}