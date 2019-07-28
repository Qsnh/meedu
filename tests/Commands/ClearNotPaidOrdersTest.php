<?php


namespace Tests\Commands;


use App\Models\Order;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\TestCase;
use Illuminate\Support\Str;
use Tests\CreatesApplication;

class ClearNotPaidOrdersTest extends TestCase
{

    use CreatesApplication, DatabaseMigrations;

    public function test_clear_not_paid_orders()
    {
        $this->artisan('clear:not_paid:orders')
            ->assertExitCode(0);
    }

    public function test_clear_not_paid_orders_with_some_data()
    {
        $order = Order::create([
            'user_id' => 1,
            'charge' => 100,
            'status' => Order::STATUS_CANCELED,
            'order_id' => Str::random(),
            'payment' => '123',
            'payment_method' => '123',
        ]);
        $order->created_at = Carbon::now()->subDays(4);
        $order->save();

        $this->artisan('clear:not_paid:orders')
            ->expectsOutput('本次删除：1')
            ->assertExitCode(0);
    }

}