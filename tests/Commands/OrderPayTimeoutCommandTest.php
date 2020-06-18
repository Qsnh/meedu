<?php

/*
 * This file is part of the Qsnh/meedu.
 *
 * (c) XiaoTeng <616896861@qq.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace Tests\Commands;

use Carbon\Carbon;
use Illuminate\Support\Str;
use Tests\OriginalTestCase;
use App\Services\Order\Models\Order;

class OrderPayTimeoutCommandTest extends OriginalTestCase
{
    public function test_order_pay_timeout()
    {
        $this->artisan('order:pay:timeout')
            ->assertExitCode(0);
    }

    public function test_order_pay_timeout_with_unpay_order()
    {
        $order = Order::create([
            'user_id' => 1,
            'charge' => 100,
            'status' => Order::STATUS_UNPAY,
            'order_id' => Str::random(),
            'payment' => '123',
            'payment_method' => '123',
        ]);
        $order->created_at = Carbon::now()->subDays(4);
        $order->save();

        $this->artisan('order:pay:timeout')
            ->assertExitCode(0);

        $order->refresh();
        $this->assertEquals(Order::STATUS_CANCELED, $order->status);
    }

    public function test_order_pay_timeout_with_paying_order()
    {
        $order = Order::create([
            'user_id' => 1,
            'charge' => 100,
            'status' => Order::STATUS_PAYING,
            'order_id' => Str::random(),
            'payment' => '123',
            'payment_method' => '123',
        ]);
        $order->created_at = Carbon::now()->subDays(4);
        $order->save();

        $this->artisan('order:pay:timeout')
            ->assertExitCode(0);

        $order->refresh();
        $this->assertEquals(Order::STATUS_CANCELED, $order->status);
    }
}
