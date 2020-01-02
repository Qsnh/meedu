<?php


namespace Tests\Commands;

use App\Services\Member\Models\User;
use App\Services\Order\Models\Order;
use Illuminate\Support\Str;
use Tests\OriginalTestCase;

class OrderHandlerCommandTest extends OriginalTestCase
{

    /**
     * @expectedException \Illuminate\Database\Eloquent\ModelNotFoundException
     */
    public function test_order_handler()
    {
        $this->artisan('order:success', ['order_id' => Str::random()]);
    }

    public function test_order_handler_with_order()
    {
        $user = factory(User::class)->create();

        $order = Order::create([
            'user_id' => $user->id,
            'charge' => 100,
            'status' => Order::STATUS_PAYING,
            'order_id' => Str::random(),
            'payment' => '123',
            'payment_method' => '123',
        ]);

        $this->artisan('order:success', ['order_id' => $order->order_id])->expectsOutput('success');

        $order->refresh();
        $this->assertEquals(Order::STATUS_PAID, $order->status);
    }

    public function test_order_handler_with_paid_order()
    {
        $order = Order::create([
            'user_id' => 1,
            'charge' => 100,
            'status' => Order::STATUS_PAID,
            'order_id' => Str::random(),
            'payment' => '123',
            'payment_method' => '123',
        ]);

        $this->artisan('order:success', ['order_id' => $order->order_id])
            ->expectsOutput('order has paid.');
    }

}