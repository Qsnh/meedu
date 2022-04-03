<?php

/*
 * This file is part of the Qsnh/meedu.
 *
 * (c) 杭州白书科技有限公司
 */

namespace App\Meedu\Payment\Alipay;

use Yansongda\Pay\Pay;
use Illuminate\Support\Facades\Log;
use App\Services\Base\Services\ConfigService;
use App\Services\Base\Interfaces\ConfigServiceInterface;

class AlipayRefund
{
    /**
     * @var ConfigService
     */
    protected $configService;

    public function __construct(ConfigServiceInterface $configService)
    {
        $this->configService = $configService;
    }

    public function handle($refundNo, $outTradeNo, $amount, $reason)
    {
        $params = [
            'out_trade_no' => $outTradeNo,
            'refund_amount' => $amount / 100,
            'refund_reason' => $reason,
            'out_request_no' => $refundNo,
        ];

        // 支付宝配置
        $config = $this->configService->getAlipayPay();
        // 回调地址
        $config['notify_url'] = route('payment.callback', ['alipay']);

        $result = Pay::alipay($config)->refund($params);
        Log::info(__METHOD__ . '|支付宝退款返回参数', $result->toArray());
    }
}
