<?php

/*
 * This file is part of the Qsnh/meedu.
 *
 * (c) XiaoTeng <616896861@qq.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace App\Meedu\Payment\Contract;

interface Payment
{
    /**
     * @param array $order
     * @param array $extra
     * @return PaymentStatus
     */
    public function create(array $order, array $extra = []): PaymentStatus;

    /**
     * @param array $order
     *
     * @return PaymentStatus
     */
    public function query(array $order): PaymentStatus;

    /**
     * @return mixed
     */
    public function callback();

    /**
     * @param array $order
     *
     * @return string
     */
    public static function payUrl(array $order): string;
}
