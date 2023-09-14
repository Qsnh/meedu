<?php

/*
 * This file is part of the MeEdu.
 *
 * (c) 杭州白书科技有限公司
 */

namespace Tests\Feature\Api\V3;

use Carbon\Carbon;
use Tests\Feature\Api\V2\Base;
use App\Services\Member\Models\User;
use App\Services\Order\Models\Order;
use App\Services\Course\Models\Course;

class PaymentTest extends Base
{
    public function test_createCourseOrder()
    {
        $user = User::factory()->create();
        $course = Course::factory()->create([
            'charge' => 100,
            'published_at' => Carbon::now()->subDays(1),
            'is_show' => Course::SHOW_YES,
        ]);
        $response = $this->user($user)->postJson('/api/v2/order/course', [
            'course_id' => $course['id'],
            'promo_code' => 0,
        ]);
        ['data' => $data] = $this->assertResponseSuccess($response);

        $response = $this->user($user)->post('/api/v3/order/pay/handPay', [
            'order_id' => $data['order_id'],
        ]);
        $this->assertResponseSuccess($response);

        // 判断支付方式改为handPay
        $order = Order::query()->where('order_id', $data['order_id'])->firstOrFail();
        $this->assertEquals('handPay', $order['payment']);
        $this->assertEquals('handPay', $order['payment_method']);
    }
}
