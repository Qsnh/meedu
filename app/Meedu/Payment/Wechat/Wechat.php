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
use Yansongda\Pay\Pay;
use App\Events\PaymentSuccessEvent;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Cache;
use App\Meedu\Payment\Contract\Payment;
use App\Meedu\Payment\Contract\PaymentStatus;
use App\Services\Base\Services\ConfigService;
use App\Services\Order\Services\OrderService;

class Wechat implements Payment
{
    protected $configService;
    protected $orderService;

    public function __construct(ConfigService $configService, OrderService $orderService)
    {
        $this->configService = $configService;
        $this->orderService = $orderService;
    }

    public function create(array $order): PaymentStatus
    {
        try {
            $payOrderData = [
                'out_trade_no' => $order['order_id'],
                'total_fee' => $order['charge'] * 100,
                'body' => $order['order_id'],
                'openid' => '',
            ];
            $createResult = Pay::wechat($this->configService->getWechatPay())->{$order['payment_method']}($payOrderData);

            // 缓存保存
            Cache::put(
                sprintf(config('cachekey.order.wechat_remote_order.name'), $order['order_id']),
                $createResult,
                config('cachekey.order.wechat_remote_order.expire')
            );

            // 构建Response
            $response = redirect(route('order.pay.wechat', [$order['order_id']]));

            return new PaymentStatus(true, $response);
        } catch (Exception $exception) {
            exception_record($exception);

            return new PaymentStatus(false);
        }
    }

    /**
     * @param array $order
     *
     * @return PaymentStatus
     */
    public function query(array $order): PaymentStatus
    {
    }

    /**
     * @return mixed|\Symfony\Component\HttpFoundation\Response
     *
     * @throws \Yansongda\Pay\Exceptions\InvalidArgumentException
     */
    public function callback()
    {
        $pay = Pay::wechat($this->configService->getWechatPay());

        try {
            $data = $pay->verify();
            Log::info($data);

            $order = $this->orderService->find($data['out_trade_no']);

            event(new PaymentSuccessEvent($order));

            return $pay->success();
        } catch (Exception $e) {
            exception_record($e);

            return $e->getMessage();
        }
    }

    /**
     * @param array $order
     *
     * @return string
     */
    public static function payUrl(array $order): string
    {
        return route('order.pay.wechat', [$order['order_id']]);
    }
}
