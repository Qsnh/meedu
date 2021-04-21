<?php

/*
 * This file is part of the Qsnh/meedu.
 *
 * (c) XiaoTeng <616896861@qq.com>
 */

namespace App\Meedu\Payment\HandPay;

use App\Meedu\Payment\Contract\Payment;
use App\Meedu\Payment\Contract\PaymentStatus;

class HandPay implements Payment
{
    public function create(array $order, array $extra = []): PaymentStatus
    {
        $data = ['order_id' => $order['order_id']];
        $response = redirect(url_append_query(route('order.pay.handPay'), ['data' => encrypt($data)]));
        return new PaymentStatus(true, $response);
    }

    public function query(array $order): PaymentStatus
    {
        return new PaymentStatus(false);
    }

    public function callback()
    {
    }

    public static function payUrl(array $order): string
    {
        $data = ['order_id' => $order['order_id']];
        return url_append_query(route('order.pay.handPay'), ['data' => encrypt($data)]);
    }
}
