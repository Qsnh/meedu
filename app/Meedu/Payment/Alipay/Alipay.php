<?php

/*
 * This file is part of the Qsnh/meedu.
 *
 * (c) XiaoTeng <616896861@qq.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace App\Meedu\Payment\Alipay;

use Exception;
use App\Models\Order;
use Yansongda\Pay\Pay;
use App\Events\PaymentSuccessEvent;
use App\Meedu\Payment\Contract\Payment;
use App\Meedu\Payment\Contract\PaymentStatus;

class Alipay implements Payment
{
    /**
     * 创建支付宝订单.
     *
     * @param Order $order
     *
     * @return PaymentStatus
     */
    public function create(Order $order): PaymentStatus
    {
        $payOrderData = [
            'out_trade_no' => $order->order_id,
            'total_amount' => app()->environment(['dev', 'local']) ? 0.01 : $order->charge,
            'subject' => $order->getOrderListTitle(),
        ];
        $createResult = Pay::alipay(config('pay.alipay'))
                           ->{$order->payment_method}($payOrderData);

        return new PaymentStatus(true, $createResult);
    }

    public function query(Order $order): PaymentStatus
    {
    }

    public function callback(Order $order)
    {
        $pay = Pay::alipay(config('pay.alipay'));

        try {
            $data = $pay->verify();
            event(new PaymentSuccessEvent($order));
        } catch (Exception $e) {
            exception_record($e);
        }

        return $pay->success();
    }
}
