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
use Yansongda\Pay\Pay;
use App\Meedu\Payment\Contract\Payment;
use App\Meedu\Payment\Contract\PaymentStatus;

class Wechat implements Payment
{
    public function create(Order $order): PaymentStatus
    {
        $payOrderData = [
            'out_trade_no' => $order->order_id,
            'total_fee' => $order->charge * 100,
            'body' => $order->getOrderListTitle(),
            'openid' => '',
        ];
        $createResult = Pay::wechat(config('pay.wechat'))
                           ->{$order->payment_method}($payOrderData);

        return new PaymentStatus(true, $createResult);
    }

    public function query(Order $order): PaymentStatus
    {
    }

    public function callback()
    {
        $pay = Pay::alipay(config('pay.wechat'));

        try {
            $data = $pay->verify();
            Log::info($data);
        } catch (Exception $e) {
            exception_record($e);
        }

        return $pay->success();
    }
}
