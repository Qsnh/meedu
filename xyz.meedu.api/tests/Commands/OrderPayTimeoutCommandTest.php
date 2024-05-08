<?php

/*
 * This file is part of the MeEdu.
 *
 * (c) 杭州白书科技有限公司
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
