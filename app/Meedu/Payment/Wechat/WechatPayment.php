<?php

/*
 * This file is part of the Qsnh/meedu.
 *
 * (c) XiaoTeng <616896861@qq.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace App\Meedu\Payment\Wechat;

use App\Models\Order;
use App\Meedu\Payment\Contract\Payment;
use App\Meedu\Payment\Contract\PaymentStatus;

class WechatPayment implements Payment
{
    public function create(Order $order): PaymentStatus
    {
    }

    public function query(Order $order): PaymentStatus
    {
    }

    public function callback()
    {
    }
}
