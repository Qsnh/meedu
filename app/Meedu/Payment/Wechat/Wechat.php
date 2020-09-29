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
use App\Constant\CacheConstant;
use App\Businesses\BusinessState;
use App\Events\PaymentSuccessEvent;
use Illuminate\Support\Facades\Log;
use App\Meedu\Payment\Contract\Payment;
use App\Services\Base\Services\CacheService;
use App\Meedu\Payment\Contract\PaymentStatus;
use App\Services\Base\Services\ConfigService;
use App\Services\Order\Services\OrderService;
use App\Services\Base\Interfaces\CacheServiceInterface;
use App\Services\Base\Interfaces\ConfigServiceInterface;
use App\Services\Order\Interfaces\OrderServiceInterface;

class Wechat implements Payment
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
        $total = $this->businessState->calculateOrderNeedPaidSum($order);
        try {
            $payOrderData = [
                'out_trade_no' => $order['order_id'],
                'total_fee' => $total * 100,
                'body' => $order['order_id'],
                'openid' => '',
            ];
            $payOrderData = array_merge($payOrderData, $extra);

            $config = $this->configService->getWechatPay();

            $createResult = Pay::wechat($config)->{$order['payment_method']}($payOrderData);

            Log::info(__METHOD__, compact('createResult'));

            // 缓存保存
            $this->cacheService->put(
                get_cache_key(CacheConstant::WECHAT_PAY_SCAN_RETURN_DATA['name'], $order['order_id']),
                $createResult,
                CacheConstant::WECHAT_PAY_SCAN_RETURN_DATA['expire']
            );

            // 构建Response
            $payUrl = route('order.pay.wechat', [$order['order_id']]);
            $response = redirect($payUrl);

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
        return new PaymentStatus(false);
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
        return route('order.pay.wechat', [$order['order_id']]);
    }
}
