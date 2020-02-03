<?php

/*
 * This file is part of the Qsnh/meedu.
 *
 * (c) XiaoTeng <616896861@qq.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace App\Meedu\Payment\HandPay;

use App\Meedu\Payment\Contract\Payment;
use App\Meedu\Payment\Contract\PaymentStatus;

class HandPay implements Payment
{
    public function create(array $order, array $extra = []): PaymentStatus
    {
        $response = redirect(route('order.pay.handPay', [$order['order_id']]));
        return new PaymentStatus(true, $response);
    }

    public function query(array $order): PaymentStatus
    {
    }

    public function callback()
    {
    }

    public static function payUrl(array $order): string
    {
        return route('order.pay.handPay', [$order['order_id']]);
    }
}
