<?php

/*
 * This file is part of the Qsnh/meedu.
 *
 * (c) 杭州白书科技有限公司
 */

namespace App\Meedu\Payment\Wechat;

use Exception;
use Yansongda\Pay\Pay;
use App\Meedu\Cache\MemoryCache;
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

class WechatJSAPI implements Payment
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
        OrderServiceInterface  $orderService,
        CacheServiceInterface  $cacheService,
        BusinessState          $businessState
    ) {
        $this->configService = $configService;
        $this->orderService = $orderService;
        $this->cacheService = $cacheService;
        $this->businessState = $businessState;
    }

    public function create(array $order, array $extra = []): PaymentStatus
    {
        // 这里无法直接创建微信支付订单
        // 因为在这个步骤里目前是无法获取openid的
        // 所以需要先跳转到支付界面然后获取openid之后再创建订单

        // 跳转的url
        $sUrl = request()->input('s_url');
        $sUrl || $sUrl = request()->input('redirect');
        $sUrl || $sUrl = url('/');
        $sUrl = clean($sUrl);//xss过滤[该参数会在wechat-jsapi.blade中渲染]

        $fUrl = request()->input('f_url');
        $fUrl || $fUrl = url('/');
        $fUrl = clean($fUrl);//同上

        // 构建Response
        $data = [
            'order_id' => $order['order_id'],
            's_url' => $sUrl,
            'f_url' => $fUrl,
            'expired_at' => time() + 3600,
        ];

        $payUrl = url_append_query(
            route('order.pay.wechat.jsapi'),
            ['data' => encrypt($data)]
        );

        $response = redirect($payUrl);

        return new PaymentStatus(true, $response);
    }

    public function createDirect(array $order, string $openid)
    {
        // 需支付金额
        $total = $this->businessState->calculateOrderNeedPaidSum($order);

        try {
            $payOrderData = [
                'out_trade_no' => $order['order_id'],
                'total_fee' => $total * 100,
                'body' => $order['order_id'],
                'openid' => $openid,
            ];

            // 微信支付配置
            $config = $this->configService->getWechatPay();
            $config['notify_url'] = route('payment.callback', ['wechat']);

            // 创建订单
            $createResult = Pay::wechat($config)->{$order['payment_method']}($payOrderData);

            return $createResult;
        } catch (Exception $exception) {
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

            Log::info(__METHOD__ . '|微信支付回调数据', compact('data'));

            // 查找订单
            $order = $this->orderService->findOrFail($data['out_trade_no']);

            // 支付订单加入内存缓存中
            MemoryCache::getInstance()->set($data['out_trade_no'], $order, true);

            event(new PaymentSuccessEvent($order));

            return $pay->success();
        } catch (Exception $e) {
            exception_record($e);

            return $e->getMessage();
        }
    }

    public static function payUrl(array $order): string
    {
        $data = ['order_id' => $order['order_id']];
        return url_append_query(
            route('order.pay.wechat.jsapi'),
            [
                'data' => encrypt($data),
            ]
        );
    }
}
