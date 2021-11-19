<?php

/*
 * This file is part of the Qsnh/meedu.
 *
 * (c) 杭州白书科技有限公司
 */

namespace App\Meedu\Payment\Wechat;

use Yansongda\Pay\Pay;
use App\Businesses\BusinessState;
use App\Events\PaymentSuccessEvent;
use Illuminate\Support\Facades\Log;
use App\Exceptions\ServiceException;
use App\Meedu\Payment\Contract\Payment;
use App\Services\Base\Services\CacheService;
use App\Meedu\Payment\Contract\PaymentStatus;
use App\Services\Base\Services\ConfigService;
use App\Services\Order\Services\OrderService;
use App\Services\Base\Interfaces\CacheServiceInterface;
use App\Services\Base\Interfaces\ConfigServiceInterface;
use App\Services\Order\Interfaces\OrderServiceInterface;

class WechatMini implements Payment
{

    /**
     * @var ConfigService
     */
    protected $configService;
    /**
     * @var OrderService
     */
    protected $orderService;
    /**
     * @var CacheService
     */
    protected $cacheService;
    protected $businessState;

    public function __construct(
        ConfigServiceInterface $configService,
        OrderServiceInterface $orderService,
        CacheServiceInterface $cacheService,
        BusinessState $businessState
    ) {
        $this->configService = $configService;
        $this->orderService = $orderService;
        $this->cacheService = $cacheService;
        $this->businessState = $businessState;
    }

    public function create(array $order, array $extra = []): PaymentStatus
    {
        $needPayTotal = $this->businessState->calculateOrderNeedPaidSum($order) * 100;

        try {
            $payOrderData = [
                'out_trade_no' => $order['order_id'],
                'total_fee' => $needPayTotal,
                'body' => $order['order_id'],
                // openid必须存在
                'openid' => $extra['open_id'],
            ];

            // 微信支付配置
            $config = $this->configService->getWechatPay();
            $config['notify_url'] = route('payment.callback', ['wechat']);

            // 创建微信支付订单
            $createResult = Pay::wechat($config)->miniapp($payOrderData);

            return new PaymentStatus(true, $createResult);
        } catch (\Exception $exception) {
            exception_record($exception);

            throw new ServiceException(__('system error'));
        }
    }

    public function query(array $order): PaymentStatus
    {
        return new PaymentStatus(false);
    }

    public function callback()
    {
        $pay = Pay::wechat($this->configService->getWechatPay());

        try {
            $data = $pay->verify();
            Log::info($data);

            $order = $this->orderService->findOrFail($data['out_trade_no']);

            event(new PaymentSuccessEvent($order));

            return $pay->success();
        } catch (\Exception $e) {
            exception_record($e);

            return $e->getMessage();
        }
    }

    public static function payUrl(array $order): string
    {
        return '';
    }
}
