<?php

/*
 * This file is part of the Qsnh/meedu.
 *
 * (c) 杭州白书科技有限公司
 */

namespace App\Meedu\Payment\Wechat;

use Yansongda\Pay\Pay;
use Illuminate\Support\Facades\Log;
use App\Exceptions\ServiceException;
use App\Services\Base\Services\ConfigService;
use App\Services\Base\Interfaces\ConfigServiceInterface;

class WechatRefund
{

    /**
     * @var ConfigService
     */
    protected $configService;

    public function __construct(ConfigServiceInterface $configService)
    {
        $this->configService = $configService;
    }

    // 如果是APP/小程序的退款订单，则需要在$extra中传入 ['type' => 'app']/['type' => 'miniapp']
    public function handle($refundNo, $outTradeNo, $total, $amount, $reason = '', $extra = [])
    {
        $params = [
            'out_trade_no' => $outTradeNo,
            'out_refund_no' => $refundNo,
            'total_fee' => $total,
            'refund_fee' => $amount,
            'refund_desc' => $reason,
        ];

        $extra && $params = array_merge($params, $extra);

        // 不抛出异常即提交成功
        $result = Pay::wechat($this->config())->refund($params);
        Log::info(__METHOD__ . '|微信支付退款返回参数', $result->toArray());
    }

    protected function config()
    {
        $config = $this->configService->getWechatPay();
        // 退款异步通知
//        $config['notify_url'] = route('wechat.pay.refund.notify');
        $config['notify_url'] = 'https://test8.meedu.xyz/addons/NotifyTest/record';

        $cert = $config['cert_client'];
        $key = $config['cert_key'];
        if (!$cert || !$key) {
            throw new ServiceException('微信API证书未配置');
        }

        $certPath = storage_path('private/wechat-pay-' . md5($cert) . '.pem');
        if (!file_exists($certPath)) {
            file_put_contents($certPath, $cert);
        }
        $keyPath = storage_path('private/wechat-pay-' . md5($key) . '.pem');
        if (!file_exists($keyPath)) {
            file_put_contents($keyPath, $key);
        }

        $config['cert_client'] = $certPath;
        $config['cert_key'] = $keyPath;

        return $config;
    }

    public function callback($next)
    {
        $wechat = Pay::wechat($this->config());
        return $next($wechat);
    }
}
