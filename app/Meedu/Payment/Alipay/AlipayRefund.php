<?php

/*
 * This file is part of the MeEdu.
 *
 * (c) 杭州白书科技有限公司
 */

namespace App\Meedu\Payment\Alipay;

use Yansongda\Pay\Pay;
use Illuminate\Support\Facades\Log;
use App\Services\Base\Interfaces\ConfigServiceInterface;

class AlipayRefund
{
    protected $configService;

    public function __construct(ConfigServiceInterface $configService)
    {
        $this->configService = $configService;
    }

    /**
     * @param $refundNo string 退款单号
     * @param $outTradeNo string 本地订单单号
     * @param $amount int 退款金额[单位：分]
     * @param $reason string 退款理由
     * @throws \Yansongda\Pay\Exceptions\GatewayException
     * @throws \Yansongda\Pay\Exceptions\InvalidConfigException
     * @throws \Yansongda\Pay\Exceptions\InvalidSignException
     */
    public function handle($refundNo, $outTradeNo, $amount, $reason)
    {
        $params = [
            'out_trade_no' => $outTradeNo,
            'refund_amount' => $amount / 100,
            'refund_reason' => $reason,
            'out_request_no' => $refundNo,
        ];

        $config = $this->configService->getAlipayPay();
        $result = Pay::alipay($config)->refund($params);
        Log::info(__METHOD__ . '|支付宝退款返回参数', $result->toArray());
    }

    public function queryIsSuccess(string $refundNo, string $orderNo): bool
    {
        // 支付宝配置
        $config = $this->configService->getAlipayPay();
        $alipay = Pay::alipay($config);
        $result = $alipay->find(
            [
                // 本地订单编号
                'out_trade_no' => $orderNo,
                // 本地退款单号
                'out_request_no' => $refundNo,
            ],
            'refund'
        );
        // 未抛出异常即请求成功
        return $result['refund_status'] ?? '' === 'REFUND_SUCCESS';
    }
}
