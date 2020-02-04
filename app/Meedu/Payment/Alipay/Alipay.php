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
use Yansongda\Pay\Pay;
use App\Businesses\BusinessState;
use App\Events\PaymentSuccessEvent;
use Illuminate\Support\Facades\Log;
use App\Meedu\Payment\Contract\Payment;
use App\Meedu\Payment\Contract\PaymentStatus;
use App\Services\Base\Services\ConfigService;
use App\Services\Order\Services\OrderService;
use App\Services\Base\Interfaces\ConfigServiceInterface;
use App\Services\Order\Interfaces\OrderServiceInterface;

class Alipay implements Payment
{
    /**
     * @var ConfigService
     */
    protected $configService;
    /**
     * @var OrderService
     */
    protected $orderService;
    protected $businessState;

    public function __construct(
        ConfigServiceInterface $configService,
        OrderServiceInterface $orderService,
        BusinessState $businessState
    ) {
        $this->configService = $configService;
        $this->orderService = $orderService;
        $this->businessState = $businessState;
    }

    /**
     * @param array $order
     * @param array $extra
     * @return PaymentStatus
     */
    public function create(array $order, array $extra = []): PaymentStatus
    {
        $total = $this->businessState->calculateOrderNeedPaidSum($order);
        $payOrderData = [
            'out_trade_no' => $order['order_id'],
            'total_amount' => $total,
            'subject' => $order['order_id'],
        ];
        $payOrderData = array_merge($payOrderData, $extra);
        $createResult = Pay::alipay($this->configService->getAlipayPay())->{$order['payment_method']}($payOrderData);

        return new PaymentStatus(true, $createResult);
    }

    /**
     * @param array $order
     *
     * @return PaymentStatus
     */
    public function query(array $order): PaymentStatus
    {
    }

    public function callback()
    {
        $pay = Pay::alipay($this->configService->getAlipayPay());

        try {
            $data = $pay->verify();
            Log::info($data);

            $order = $this->orderService->findOrFail($data['out_trade_no']);

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
        return route('order.pay', [$order['order_id']]);
    }
}
