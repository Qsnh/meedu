<?php

/*
 * This file is part of the Qsnh/meedu.
 *
 * (c) 杭州白书科技有限公司
 */

namespace App\Meedu\Payment\HandPay;

use App\Meedu\Payment\Contract\Payment;
use App\Meedu\Payment\Contract\PaymentStatus;

class HandPay implements Payment
{
    public function create(array $order, array $extra = []): PaymentStatus
    {
        return new PaymentStatus(true, '');
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
        return '';
    }
}
