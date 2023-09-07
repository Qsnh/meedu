<?php

/*
 * This file is part of the Qsnh/meedu.
 *
 * (c) 杭州白书科技有限公司
 */

namespace Tests\Unit\Bus;

use Carbon\Carbon;
use Tests\TestCase;
use App\Bus\RefundBus;
use App\Exceptions\ServiceException;
use App\Services\Member\Models\User;
use App\Services\Order\Models\Order;
use App\Meedu\Payment\Alipay\AlipayRefund;
use App\Meedu\Payment\Wechat\WechatRefund;
use App\Services\Order\Models\OrderRefund;
use Mockery\Adapter\Phpunit\MockeryPHPUnitIntegration;

class RefundBusTest extends TestCase
{
    use MockeryPHPUnitIntegration;

    /**
     * @var RefundBus
     */
    protected $refundBus;

    public function setUp(): void
    {
        parent::setUp();
        $this->refundBus = $this->app->make(RefundBus::class);
        $this->startMockery();
    }

    public function tearDown(): void
    {
        $this->closeMockery();
        parent::tearDown();
    }

    public function test_isProcessed()
    {
        $this->assertTrue($this->refundBus->isProcessed(['status' => 5]));//成功
        $this->assertTrue($this->refundBus->isProcessed(['status' => 9]));//失败
        $this->assertTrue($this->refundBus->isProcessed(['status' => 13]));//关闭

        $this->assertFalse($this->refundBus->isProcessed(['status' => 1]));
    }

    public function test_isSuccess()
    {
        $this->assertTrue($this->refundBus->isSuccess(5));

        $this->assertFalse($this->refundBus->isSuccess(1));
        $this->assertFalse($this->refundBus->isSuccess(9));
        $this->assertFalse($this->refundBus->isSuccess(13));
    }

    public function test_wechatRefundStatusMap()
    {
        $this->assertEquals(5, $this->refundBus->wechatRefundStatusMap('SUCCESS'));
        $this->assertEquals(9, $this->refundBus->wechatRefundStatusMap('CHANGE'));
        $this->assertEquals(13, $this->refundBus->wechatRefundStatusMap('REFUNDCLOSE'));

        $this->expectExceptionMessage(__('状态异常'));
        $this->refundBus->wechatRefundStatusMap('UNKNOWN');
    }

    public function test_handle_unsupport_payment()
    {
        $order = [
            'user_id' => 0,
            'charge' => 100,
            'status' => 1,
            'order_id' => '123123',
            'payment' => 'meedu-pay',
            'payment_method' => 'web',
            'is_refund' => 0,
            'last_refund_at' => null,
        ];

        $refundNo = date('YmdHis');

        $this->expectExceptionMessage(__('当前订单支付渠道不支持退款'));
        $this->refundBus->handle($order, $refundNo, 100, 100, 'test');
    }

    public function test_handle_with_alipay()
    {
        $alipayRefundMock = \Mockery::mock(AlipayRefund::class);
        $alipayRefundMock->shouldReceive('handle')->withAnyArgs()->andReturnNull();
        $this->app->instance(AlipayRefund::class, $alipayRefundMock);

        $order = [
            'user_id' => 0,
            'charge' => 100,
            'status' => 1,
            'order_id' => '123123',
            'payment' => 'alipay',
            'payment_method' => 'web',
            'is_refund' => 0,
            'last_refund_at' => null,
        ];

        $refundNo = date('YmdHis');

        $this->refundBus->handle($order, $refundNo, 100, 100, 'test');
    }

    public function test_handle_with_wechat()
    {
        $wechatRefundMock = \Mockery::mock(WechatRefund::class);
        $wechatRefundMock->shouldReceive('handle')->withAnyArgs()->andReturnNull();
        $this->app->instance(WechatRefund::class, $wechatRefundMock);

        $order = [
            'user_id' => 0,
            'charge' => 100,
            'status' => 1,
            'order_id' => '123123',
            'payment' => 'wechat',
            'payment_method' => 'web',
            'is_refund' => 0,
            'last_refund_at' => null,
        ];

        $refundNo = date('YmdHis');

        $this->refundBus->handle($order, $refundNo, 100, 100, 'test');
    }

    public function test_handle_with_wechat_and_miniapp()
    {
        $wechatRefundMock = \Mockery::mock(WechatRefund::class);
        $wechatRefundMock->shouldReceive('handle')->withAnyArgs()->andReturnNull();
        $this->app->instance(WechatRefund::class, $wechatRefundMock);

        $order = [
            'user_id' => 0,
            'charge' => 100,
            'status' => 1,
            'order_id' => '123123',
            'payment' => 'wechat',
            'payment_method' => 'miniapp',
            'is_refund' => 0,
            'last_refund_at' => null,
        ];

        $refundNo = date('YmdHis');

        $this->refundBus->handle($order, $refundNo, 100, 100, 'test');
    }

    public function test_handle_with_wechat_and_wechatApp()
    {
        $wechatRefundMock = \Mockery::mock(WechatRefund::class);
        $wechatRefundMock->shouldReceive('handle')->withAnyArgs()->andReturnNull();
        $this->app->instance(WechatRefund::class, $wechatRefundMock);

        $order = [
            'user_id' => 0,
            'charge' => 100,
            'status' => 1,
            'order_id' => '123123',
            'payment' => 'wechatApp',
            'payment_method' => 'web',
            'is_refund' => 0,
            'last_refund_at' => null,
        ];

        $refundNo = date('YmdHis');

        $this->refundBus->handle($order, $refundNo, 100, 100, 'test');

        $this->assertEquals(1, 1);
    }

    public function test_queryHandler_with_local()
    {
        $alipayRefundMock = \Mockery::mock(AlipayRefund::class);
        $alipayRefundMock->shouldReceive('queryIsSuccess')->withAnyArgs()->andReturnTrue();
        $this->app->instance(AlipayRefund::class, $alipayRefundMock);

        $user = User::factory()->create();

        $order = Order::create([
            'user_id' => $user['id'],
            'charge' => 100,
            'order_id' => '123123',
            'payment' => 'alipay',
            'payment_method' => 'web',
            'is_refund' => 0,
            'last_refund_at' => null,
        ]);

        $refundNo = date('YmdHis');

        $orderRefund = OrderRefund::create([
            'order_id' => $order['id'],
            'user_id' => $order['user_id'],
            'payment' => $order['payment'],
            'total_amount' => $order['charge'],
            'amount' => $order['charge'],
            'refund_no' => $refundNo,
            'reason' => 'test',
            'is_local' => 1,
            'status' => 1,
        ]);

        $refundData = $orderRefund->toArray();
        $refundData['created_at'] = Carbon::now()->subMinutes(3);
        $refundData['order'] = ['order_id' => $order['id']];

        $this->refundBus->queryHandler($refundData);

        $orderRefund->refresh();
        $this->assertEquals(1, $orderRefund['status']);
    }

    public function test_queryHandler_with_alipay_and_success()
    {
        $alipayRefundMock = \Mockery::mock(AlipayRefund::class);
        $alipayRefundMock->shouldReceive('queryIsSuccess')->withAnyArgs()->andReturnTrue();
        $this->app->instance(AlipayRefund::class, $alipayRefundMock);

        $user = User::factory()->create();

        $order = Order::create([
            'user_id' => $user['id'],
            'charge' => 100,
            'order_id' => '123123',
            'payment' => 'alipay',
            'payment_method' => 'web',
            'is_refund' => 0,
            'last_refund_at' => null,
        ]);

        $refundNo = date('YmdHis');

        $orderRefund = OrderRefund::create([
            'order_id' => $order['id'],
            'user_id' => $order['user_id'],
            'payment' => $order['payment'],
            'total_amount' => $order['charge'],
            'amount' => $order['charge'],
            'refund_no' => $refundNo,
            'reason' => 'test',
            'is_local' => 0,
            'status' => 1,
        ]);

        $refundData = $orderRefund->toArray();
        $refundData['created_at'] = Carbon::now()->subMinutes(3);
        $refundData['order'] = ['order_id' => $order['id']];

        $this->refundBus->queryHandler($refundData);

        $orderRefund->refresh();
        $this->assertEquals(5, $orderRefund['status']);
    }

    public function test_queryHandler_with_alipay_and_failure()
    {
        $alipayRefundMock = \Mockery::mock(AlipayRefund::class);
        $alipayRefundMock->shouldReceive('queryIsSuccess')->withAnyArgs()->andReturnFalse();
        $this->app->instance(AlipayRefund::class, $alipayRefundMock);

        $user = User::factory()->create();

        $order = Order::create([
            'user_id' => $user['id'],
            'charge' => 100,
            'order_id' => '123123',
            'payment' => 'alipay',
            'payment_method' => 'web',
            'is_refund' => 0,
            'last_refund_at' => null,
        ]);

        $refundNo = date('YmdHis');

        $orderRefund = OrderRefund::create([
            'order_id' => $order['id'],
            'user_id' => $order['user_id'],
            'payment' => $order['payment'],
            'total_amount' => $order['charge'],
            'amount' => $order['charge'],
            'refund_no' => $refundNo,
            'reason' => 'test',
            'is_local' => 0,
            'status' => 1,
        ]);

        $refundData = $orderRefund->toArray();
        $refundData['created_at'] = Carbon::now()->subMinutes(3);
        $refundData['order'] = ['order_id' => $order['id']];

        $this->refundBus->queryHandler($refundData);

        $orderRefund->refresh();
        $this->assertEquals(9, $orderRefund['status']);
    }

    public function test_queryHandler_with_alipay_and_throw_exception()
    {
        $alipayRefundMock = \Mockery::mock(AlipayRefund::class);
        $alipayRefundMock->shouldReceive('queryIsSuccess')->withAnyArgs()->andThrowExceptions([new \Exception('test')]);
        $this->app->instance(AlipayRefund::class, $alipayRefundMock);

        $user = User::factory()->create();

        $order = Order::create([
            'user_id' => $user['id'],
            'charge' => 100,
            'order_id' => '123123',
            'payment' => 'alipay',
            'payment_method' => 'web',
            'is_refund' => 0,
            'last_refund_at' => null,
        ]);

        $refundNo = date('YmdHis');

        $orderRefund = OrderRefund::create([
            'order_id' => $order['id'],
            'user_id' => $order['user_id'],
            'payment' => $order['payment'],
            'total_amount' => $order['charge'],
            'amount' => $order['charge'],
            'refund_no' => $refundNo,
            'reason' => 'test',
            'is_local' => 0,
            'status' => 1,
        ]);

        $refundData = $orderRefund->toArray();
        $refundData['created_at'] = Carbon::now()->subMinutes(3);
        $refundData['order'] = ['order_id' => $order['id']];

        $this->refundBus->queryHandler($refundData);

        $orderRefund->refresh();
        $this->assertEquals(1, $orderRefund['status']);
    }

    public function test_queryHandler_with_wechat_and_success()
    {
        $refundMock = \Mockery::mock(WechatRefund::class);
        $refundMock->shouldReceive('queryStatus')->withAnyArgs()->andReturn('SUCCESS');
        $this->app->instance(WechatRefund::class, $refundMock);

        $user = User::factory()->create();

        $order = Order::create([
            'user_id' => $user['id'],
            'charge' => 100,
            'order_id' => '123123',
            'payment' => 'wechat',
            'payment_method' => 'web',
            'is_refund' => 0,
            'last_refund_at' => null,
        ]);

        $refundNo = date('YmdHis');

        $orderRefund = OrderRefund::create([
            'order_id' => $order['id'],
            'user_id' => $order['user_id'],
            'payment' => $order['payment'],
            'total_amount' => $order['charge'],
            'amount' => $order['charge'],
            'refund_no' => $refundNo,
            'reason' => 'test',
            'is_local' => 0,
            'status' => 1,
        ]);

        $refundData = $orderRefund->toArray();
        $refundData['created_at'] = Carbon::now()->subMinutes(3);
        $refundData['order'] = ['order_id' => $order['id']];

        $this->refundBus->queryHandler($refundData);

        $orderRefund->refresh();
        $this->assertEquals(5, $orderRefund['status']);
    }

    public function test_queryHandler_with_wechat_and_failure()
    {
        $refundMock = \Mockery::mock(WechatRefund::class);
        $refundMock->shouldReceive('queryStatus')->withAnyArgs()->andReturn('CHANGE');
        $this->app->instance(WechatRefund::class, $refundMock);

        $user = User::factory()->create();

        $order = Order::create([
            'user_id' => $user['id'],
            'charge' => 100,
            'order_id' => '123123',
            'payment' => 'wechat',
            'payment_method' => 'web',
            'is_refund' => 0,
            'last_refund_at' => null,
        ]);

        $refundNo = date('YmdHis');

        $orderRefund = OrderRefund::create([
            'order_id' => $order['id'],
            'user_id' => $order['user_id'],
            'payment' => $order['payment'],
            'total_amount' => $order['charge'],
            'amount' => $order['charge'],
            'refund_no' => $refundNo,
            'reason' => 'test',
            'is_local' => 0,
            'status' => 1,
        ]);

        $refundData = $orderRefund->toArray();
        $refundData['created_at'] = Carbon::now()->subMinutes(3);
        $refundData['order'] = ['order_id' => $order['id']];

        $this->refundBus->queryHandler($refundData);

        $orderRefund->refresh();
        $this->assertEquals(9, $orderRefund['status']);
    }

    public function test_queryHandler_with_wechat_and_close()
    {
        $refundMock = \Mockery::mock(WechatRefund::class);
        $refundMock->shouldReceive('queryStatus')->withAnyArgs()->andReturn('REFUNDCLOSE');
        $this->app->instance(WechatRefund::class, $refundMock);

        $user = User::factory()->create();

        $order = Order::create([
            'user_id' => $user['id'],
            'charge' => 100,
            'order_id' => '123123',
            'payment' => 'wechat',
            'payment_method' => 'web',
            'is_refund' => 0,
            'last_refund_at' => null,
        ]);

        $refundNo = date('YmdHis');

        $orderRefund = OrderRefund::create([
            'order_id' => $order['id'],
            'user_id' => $order['user_id'],
            'payment' => $order['payment'],
            'total_amount' => $order['charge'],
            'amount' => $order['charge'],
            'refund_no' => $refundNo,
            'reason' => 'test',
            'is_local' => 0,
            'status' => 1,
        ]);

        $refundData = $orderRefund->toArray();
        $refundData['created_at'] = Carbon::now()->subMinutes(3);
        $refundData['order'] = ['order_id' => $order['id']];

        $this->refundBus->queryHandler($refundData);

        $orderRefund->refresh();
        $this->assertEquals(13, $orderRefund['status']);
    }

    public function test_queryHandler_with_wechat_and_throw_service_exception()
    {
        $refundMock = \Mockery::mock(WechatRefund::class);
        $refundMock->shouldReceive('queryStatus')->withAnyArgs()->andThrowExceptions([new ServiceException('test')]);
        $this->app->instance(WechatRefund::class, $refundMock);

        $user = User::factory()->create();

        $order = Order::create([
            'user_id' => $user['id'],
            'charge' => 100,
            'order_id' => '123123',
            'payment' => 'wechat',
            'payment_method' => 'web',
            'is_refund' => 0,
            'last_refund_at' => null,
        ]);

        $refundNo = date('YmdHis');

        $orderRefund = OrderRefund::create([
            'order_id' => $order['id'],
            'user_id' => $order['user_id'],
            'payment' => $order['payment'],
            'total_amount' => $order['charge'],
            'amount' => $order['charge'],
            'refund_no' => $refundNo,
            'reason' => 'test',
            'is_local' => 0,
            'status' => 1,
        ]);

        $refundData = $orderRefund->toArray();
        $refundData['created_at'] = Carbon::now()->subMinutes(3);
        $refundData['order'] = ['order_id' => $order['id']];

        $this->refundBus->queryHandler($refundData);

        $orderRefund->refresh();
        $this->assertEquals(1, $orderRefund['status']);
    }

    public function test_queryHandler_with_wechat_and_throw_exception()
    {
        $refundMock = \Mockery::mock(WechatRefund::class);
        $refundMock->shouldReceive('queryStatus')->withAnyArgs()->andThrowExceptions([new \Exception('test')]);
        $this->app->instance(WechatRefund::class, $refundMock);

        $user = User::factory()->create();

        $order = Order::create([
            'user_id' => $user['id'],
            'charge' => 100,
            'order_id' => '123123',
            'payment' => 'wechat',
            'payment_method' => 'web',
            'is_refund' => 0,
            'last_refund_at' => null,
        ]);

        $refundNo = date('YmdHis');

        $orderRefund = OrderRefund::create([
            'order_id' => $order['id'],
            'user_id' => $order['user_id'],
            'payment' => $order['payment'],
            'total_amount' => $order['charge'],
            'amount' => $order['charge'],
            'refund_no' => $refundNo,
            'reason' => 'test',
            'is_local' => 0,
            'status' => 1,
        ]);

        $refundData = $orderRefund->toArray();
        $refundData['created_at'] = Carbon::now()->subMinutes(3);
        $refundData['order'] = ['order_id' => $order['id']];

        $this->refundBus->queryHandler($refundData);

        $orderRefund->refresh();
        $this->assertEquals(1, $orderRefund['status']);
    }
}
