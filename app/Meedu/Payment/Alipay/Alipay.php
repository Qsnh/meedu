<?php

/*
 * This file is part of the Qsnh/meedu.
 *
 * (c) 杭州白书科技有限公司
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
        // 计算需要支付的金额
        $total = $this->businessState->calculateOrderNeedPaidSum($order);

        // 组装数据
        $payOrderData = [
            'out_trade_no' => $order['order_id'],
            'total_amount' => $total,
            'subject' => $order['order_id'],
        ];
        $payOrderData = array_merge($payOrderData, $extra);

        // 支付宝配置
        $config = $this->configService->getAlipayPay();
        // 回调地址
        $config['notify_url'] = route('payment.callback', ['alipay']);
        // 同步返回地址
        $returnUrl = request()->input('redirect');
        $returnUrl || $returnUrl = request()->input('s_url');
        $returnUrl || $returnUrl = route('order.pay.success');
        $config['return_url'] = $returnUrl;

        // 创建支付宝支付订单
        $createResult = Pay::alipay($config)->{$order['payment_method']}($payOrderData);

        return new PaymentStatus(true, $createResult);
    }

    /**
     * 订单查询
     *
     * @param array $order
     *
     * @return PaymentStatus
     */
    public function query(array $order): PaymentStatus
    {
        return new PaymentStatus(false);
    }

    public function callback()
    {
        $pay = Pay::alipay($this->configService->getAlipayPay());

        try {
            $data = $pay->verify();

            Log::info(__METHOD__, [$data]);

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
