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
        $config['notify_url'] = route('wechat.pay.refund.notify');

        if (!$config['cert_client'] || !$config['cert_key']) {
            throw new ServiceException(__('微信证书未配置'));
        }

        if (!is_file($config['cert_client']) || !is_file($config['cert_key'])) {
            throw new ServiceException(__('微信证书未配置'));
        }

        return $config;
    }

    public function callback($next)
    {
        $wechat = Pay::wechat($this->config());
        return $next($wechat);
    }

    public function queryStatus(string $refundNo)
    {
        $wechat = Pay::wechat($this->config());
        // 不抛出异常即请求成功
        $result = $wechat->find(['out_refund_no' => $refundNo], 'refund');
        // 因为上面查询的时候我传入的是out_refund_no，因此返回的结果只会有一条
        // 也就是可以直接读取 `refund_status_0`
        return $result['refund_status_0'];
    }
}
