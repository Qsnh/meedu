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

use App\Models\Order;

interface Payment
{
    /**
     * 创建订单.
     *
     * @param $data
     *
     * @return PaymentStatus
     */
    public function create(Order $order): PaymentStatus;

    /**
     * 主动查询.
     *
     * @param $orderId
     *
     * @return PaymentStatus
     */
    public function query(Order $order): PaymentStatus;

    /**
     * 回调.
     *
     * @return mixed
     */
    public function callback();

    /**
     * 获取继续支付的URL.
     *
     * @param Order $order
     *
     * @return mixed
     */
    public static function payUrl(Order $order): string;
}
