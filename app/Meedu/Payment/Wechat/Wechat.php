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

use Exception;
use App\Models\Order;
use Yansongda\Pay\Pay;
use App\Events\PaymentSuccessEvent;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Cache;
use App\Meedu\Payment\Contract\Payment;
use App\Meedu\Payment\Contract\PaymentStatus;

class Wechat implements Payment
{
    public function create(Order $order): PaymentStatus
    {
        try {
            $payOrderData = [
                'out_trade_no' => $order->order_id,
                'total_fee' => app()->environment(['dev', 'local']) ? 1 : $order->charge * 100,
                'body' => $order->getOrderListTitle(),
                'openid' => '',
            ];
            $createResult = Pay::wechat(config('pay.wechat'))
                ->{$order->payment_method}($payOrderData);

            // 缓存保存
            Cache::put(
                sprintf(config('cachekey.order.wechat_remote_order.name'), $order->order_id),
                $createResult,
                config('cachekey.order.wechat_remote_order.expire')
            );

            // 构建Response
            $response = redirect(route('order.pay.wechat', [$order->order_id]));

            return new PaymentStatus(true, $response);
        } catch (Exception $exception) {
            exception_record($exception);

            return new PaymentStatus(false);
        }
    }

    /**
     * 主动轮询.
     *
     * @param Order $order
     *
     * @return PaymentStatus
     */
    public function query(Order $order): PaymentStatus
    {
    }

    /**
     * @return mixed|\Symfony\Component\HttpFoundation\Response
     *
     * @throws \Yansongda\Pay\Exceptions\InvalidArgumentException
     */
    public function callback()
    {
        $pay = Pay::wechat(config('pay.wechat'));

        try {
            $data = $pay->verify();
            Log::info($data);

            $order = Order::whereOrderId($data['out_trade_no'])->firstOrFail();

            event(new PaymentSuccessEvent($order));
        } catch (Exception $e) {
            exception_record($e);
        }

        return $pay->success();
    }

    /**
     * 支付URL.
     *
     * @param Order $order
     *
     * @return mixed|string
     */
    public static function payUrl(Order $order): string
    {
        return route('order.pay.wechat', [$order->order_id]);
    }
}
