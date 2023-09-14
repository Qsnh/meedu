<?php

/*
 * This file is part of the MeEdu.
 *
 * (c) 杭州白书科技有限公司
 */

namespace Tests\Commands;

use Tests\OriginalTestCase;
use App\Services\Member\Models\User;
use App\Services\Order\Models\Order;
use App\Meedu\Payment\Alipay\AlipayRefund;
use App\Services\Order\Models\OrderRefund;
use Mockery\Adapter\Phpunit\MockeryPHPUnitIntegration;

class RefundQueryCommandTest extends OriginalTestCase
{
    use MockeryPHPUnitIntegration;

    public function setUp(): void
    {
        parent::setUp();
        $this->startMockery();
    }

    public function tearDown(): void
    {
        $this->closeMockery();
        parent::tearDown();
    }

    public function test_query_with_empty_orders()
    {
        $this->artisan('meedu:refund:query')
            ->expectsOutput('暂无退款订单需要处理')
            ->assertSuccessful();
    }

    public function test_query_with_orders()
    {
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

        $refundOrder = OrderRefund::create([
            'order_id' => $order['id'],
            'user_id' => $order['user_id'],
            'payment' => $order['payment'],
            'total_amount' => $order['charge'],
            'amount' => $order['charge'],
            'refund_no' => date('YmdHis'),
            'reason' => 'test',
            'is_local' => 0,
            'status' => 1,
        ]);

        $alipayRefundMock = \Mockery::mock(AlipayRefund::class);
        $alipayRefundMock->shouldReceive('queryIsSuccess')->withAnyArgs()->andReturnFalse();
        $this->app->instance(AlipayRefund::class, $alipayRefundMock);

        $this->artisan('meedu:refund:query')
            ->expectsOutput(sprintf('查询退款订单[%s][%s]', $refundOrder['payment'], $refundOrder['refund_no']))
            ->assertSuccessful();
    }
}
