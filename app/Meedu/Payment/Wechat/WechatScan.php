<?php

/*
 * This file is part of the Qsnh/meedu.
 *
 * (c) 杭州白书科技有限公司
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

class WechatScan implements Payment
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
        $total = $this->businessState->calculateOrderNeedPaidSum($order) * 100;
        try {
            $payOrderData = [
                'out_trade_no' => $order['order_id'],
                'total_fee' => $total,
                'body' => $order['order_id'],
                'openid' => '',
            ];
            $payOrderData = array_merge($payOrderData, $extra);

            $config = $this->configService->getWechatPay();
            // 回调地址
            $config['notify_url'] = route('payment.callback', ['wechat']);

            // 创建微信支付订单
            // $createResult['code_url'] = 微信支付二维码的文本值[需要根据该文本值生成二维码]
            $createResult = Pay::wechat($config)->scan($payOrderData);

            // 构建Response
            if (request()->wantsJson()) {
                $response = $createResult;
            } else {
                // 如果需要打开微信扫码支付界面，则需要构建一个page
                // 返回redirect，跳转到构建的page

                // 微信支付订单先临时保存
                // 当跳转到扫码支付page的时候再读取该数据
                $this->cacheService->put(
                    get_cache_key(CacheConstant::WECHAT_PAY_SCAN_RETURN_DATA['name'], $order['order_id']),
                    $createResult,
                    CacheConstant::WECHAT_PAY_SCAN_RETURN_DATA['expire']
                );

                // 构建page
                $redirectUrl = request()->input('s_url');
                $redirectUrl || $redirectUrl = request()->input('redirect');
                $payUrl = url_append_query(route('order.pay.wechat', [$order['order_id']]), [
                    'redirect_url' => $redirectUrl,
                ]);
                $response = redirect($payUrl);
            }

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
