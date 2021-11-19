<?php

/*
 * This file is part of the Qsnh/meedu.
 *
 * (c) 杭州白书科技有限公司
 */

namespace Tests\Services\Order;

use Carbon\Carbon;
use Tests\TestCase;
use App\Exceptions\ServiceException;
use App\Services\Member\Models\Role;
use App\Services\Member\Models\User;
use App\Services\Order\Models\Order;
use Illuminate\Support\Facades\Auth;
use App\Services\Course\Models\Video;
use App\Services\Course\Models\Course;
use App\Services\Order\Models\PromoCode;
use App\Services\Order\Models\OrderGoods;
use App\Services\Order\Services\OrderService;
use App\Services\Order\Interfaces\OrderServiceInterface;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class OrderServiceTest extends TestCase
{

    /**
     * @var OrderService
     */
    protected $service;

    public function setUp(): void
    {
        parent::setUp();
        $this->service = $this->app->make(OrderServiceInterface::class);
    }

    public function test_createCourseOrder()
    {
        $user = User::factory()->create();
        $course = Course::factory()->create();

        $order = $this->service->createCourseOrder($user->id, $course->toArray(), 0);
        $this->assertNotEmpty($order);
    }

    public function test_createCourseOrder_with_promoCode()
    {
        $user = User::factory()->create();
        $course = Course::factory()->create();
        $promoCode = PromoCode::factory()->create([
            'user_id' => 0,
            'invited_user_reward' => 10,
            'used_times' => 0,
        ]);

        $order = $this->service->createCourseOrder($user['id'], $course->toArray(), $promoCode['id']);
        $this->assertNotEmpty($order);
    }

    public function test_createVideoOrder()
    {
        $user = User::factory()->create();
        $video = Video::factory()->create();

        $order = $this->service->createVideoOrder($user->id, $video->toArray(), 0);
        $this->assertNotEmpty($order);
    }

    public function test_createVideoOrder_with_PromoCode()
    {
        $user = User::factory()->create();
        $video = Video::factory()->create();
        $promoCode = PromoCode::factory()->create([
            'invited_user_reward' => 10,
            'used_times' => 0,
        ]);

        $order = $this->service->createVideoOrder($user->id, $video->toArray(), $promoCode->id);
        $this->assertNotEmpty($order);
    }

    public function test_createRoleOrder()
    {
        $user = User::factory()->create();
        $role = Role::factory()->create();

        $promoCode = PromoCode::factory()->create([
            'invited_user_reward' => 10,
            'used_times' => 0,
        ]);

        $order = $this->service->createRoleOrder($user->id, $role->toArray(), $promoCode['id']);
        $this->assertNotEmpty($order);
    }

    public function test_createRoleOrder_with_promoCode()
    {
        $user = User::factory()->create();
        $role = Role::factory()->create();

        $order = $this->service->createRoleOrder($user->id, $role->toArray(), 0);
        $this->assertNotEmpty($order);
    }


    public function test_findNoPaid()
    {
        $this->expectException(ModelNotFoundException::class);

        $order = Order::factory()->create([
            'status' => Order::STATUS_UNPAY,
        ]);
        $order1 = Order::factory()->create([
            'status' => Order::STATUS_CANCELED,
        ]);

        $this->assertNotEmpty($this->service->findNoPaid($order->order_id));
        $this->service->findNoPaid($order1->order_id);
    }

    public function test_findUserNoPaid()
    {
        $this->expectException(ModelNotFoundException::class);

        $user = User::factory()->create();
        Auth::login($user);

        $order = Order::factory()->create([
            'status' => Order::STATUS_UNPAY,
            'user_id' => $user->id,
        ]);
        $order1 = Order::factory()->create([
            'status' => Order::STATUS_UNPAY,
        ]);

        $this->assertNotEmpty($this->service->findUserNoPaid($order->order_id));
        $this->service->findUserNoPaid($order1->order_id);
    }

    public function test_find()
    {
        $order = Order::factory()->create([
            'status' => Order::STATUS_UNPAY,
        ]);

        $this->assertNotEmpty($this->service->findOrFail($order->order_id));
    }

    public function test_findUser()
    {
        $this->expectException(ModelNotFoundException::class);

        $user = User::factory()->create();
        Auth::login($user);

        $order = Order::factory()->create([
            'status' => Order::STATUS_UNPAY,
            'user_id' => $user->id,
        ]);
        $order1 = Order::factory()->create([
            'status' => Order::STATUS_UNPAY,
        ]);

        $this->assertNotEmpty($this->service->findUser($order->order_id));
        $this->service->findUser($order1->order_id);
    }

    public function test_findId()
    {
        $order = Order::factory()->create([
            'status' => Order::STATUS_UNPAY,
        ]);

        $o = $this->service->findId($order->id);
        $this->assertNotEmpty($order->order_id, $o['order_id']);
    }

    public function test_findUserId()
    {
        $this->expectException(ModelNotFoundException::class);

        $user = User::factory()->create();
        $order = Order::factory()->create([
            'status' => Order::STATUS_UNPAY,
            'user_id' => $user->id,
        ]);
        $order1 = Order::factory()->create([
            'status' => Order::STATUS_UNPAY,
        ]);

        $o = $this->service->findId($order->id);
        $this->assertNotEmpty($order->order_id, $o['order_id']);

        $this->service->findUserId($order1->id);
    }

    public function test_change2Paying()
    {
        $order = Order::factory()->create([
            'status' => Order::STATUS_UNPAY,
        ]);

        $this->service->change2Paying($order->id, []);
        $order->refresh();
        $this->assertEquals($order->status, Order::STATUS_PAYING);
    }

    public function test_change2Paying_with_error_status()
    {
        $this->expectException(ServiceException::class);

        $order = Order::factory()->create([
            'status' => Order::STATUS_PAYING,
        ]);

        $this->service->change2Paying($order->id, []);
    }

    public function test_cancel()
    {
        $order = Order::factory()->create([
            'status' => Order::STATUS_UNPAY,
        ]);

        $this->service->cancel($order->id);
        $order->refresh();
        $this->assertEquals($order->status, Order::STATUS_CANCELED);
    }

    public function test_cancel_with_error_status()
    {
        $this->expectException(ServiceException::class);

        $order = Order::factory()->create([
            'status' => Order::STATUS_PAID,
        ]);

        $this->service->cancel($order->id);
    }

    public function test_userOrdersPaginate()
    {
        $user = User::factory()->create();
        Auth::login($user);

        $orders = Order::factory()->count(10)->create([
            'user_id' => $user->id,
        ]);

        $list = $this->service->userOrdersPaginate(2, 4);

        $this->assertEquals(10, $list['total']);
        $this->assertEquals(4, count($list['list']));
    }

    public function test_changePaid()
    {
        $order = Order::factory()->create([
            'status' => Order::STATUS_PAYING,
        ]);

        $this->service->changePaid($order->id);
        $order->refresh();
        $this->assertEquals($order->status, Order::STATUS_PAID);
    }

    public function test_getOrderProducts()
    {
        $order = Order::factory()->create();
        $orderGoods = OrderGoods::factory()->count(11)->create([
            'oid' => $order->id,
            'user_id' => 1,
        ]);

        $list = $this->service->getOrderProducts($order->id);

        $this->assertEquals(11, count($list));
    }

    public function test_getTimeoutOrders()
    {
        Order::factory()->create(['status' => Order::STATUS_PAYING]);
        Order::factory()->create(['status' => Order::STATUS_PAID]);
        Order::factory()->create(['status' => Order::STATUS_UNPAY]);

        $list = $this->service->getTimeoutOrders(Carbon::now()->addDays(10));

        $this->assertEquals(2, count($list));
    }
}
