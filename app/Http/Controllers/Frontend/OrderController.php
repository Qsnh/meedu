<?php

/*
 * This file is part of the Qsnh/meedu.
 *
 * (c) 杭州白书科技有限公司
 */

namespace App\Http\Controllers\Frontend;

use App\Meedu\Wechat;
use Illuminate\Http\Request;
use App\Constant\CacheConstant;
use App\Businesses\BusinessState;
use App\Exceptions\SystemException;
use App\Exceptions\ServiceException;
use App\Meedu\Payment\Wechat\WechatJSAPI;
use App\Services\Base\Services\CacheService;
use App\Services\Order\Services\OrderService;
use App\Services\Base\Interfaces\CacheServiceInterface;
use App\Services\Order\Interfaces\OrderServiceInterface;

class OrderController extends FrontendController
{
    /**
     * @var OrderService
     */
    protected $orderService;

    /**
     * @var BusinessState
     */
    protected $businessState;

    /**
     * @var CacheService
     */
    protected $cacheService;

    public function __construct(
        OrderServiceInterface $orderService,
        BusinessState $businessState,
        CacheServiceInterface $cacheService
    ) {
        parent::__construct();

        $this->orderService = $orderService;
        $this->businessState = $businessState;
        $this->cacheService = $cacheService;
    }

    // 发起支付
    public function pay(Request $request)
    {
        $orderId = $request->input('order_id');
        $order = $this->orderService->findUserNoPaid($orderId);

        $scene = $request->input('scene');
        $payment = $request->input('payment');
        if (!$payment) {
            throw new ServiceException(__('支付网关不存在'));
        }
        $payments = get_payments($scene);
        $paymentMethod = $payments[$payment][$scene] ?? '';
        if (!$paymentMethod) {
            throw new SystemException(__('支付网关不存在'));
        }

        // 更新订单的支付方式
        $updateData = [
            'payment' => $payment,
            'payment_method' => $paymentMethod,
        ];
        $this->orderService->change2Paying($order['id'], $updateData);
        $order = array_merge($order, $updateData);

        // 创建远程订单
        $paymentHandler = app()->make($payments[$payment]['handler']);
        $createResult = $paymentHandler->create($order);
        if ($createResult->status === false) {
            throw new SystemException(__('系统错误'));
        }

        return $createResult->data;
    }

    // 支付成功界面
    public function paySuccess(Request $request)
    {
        $orderId = $request->input('out_trade_no', '');
        $order = $this->orderService->findUser($orderId);

        return v('frontend.order.success', compact('order'));
    }

    // 微信扫码支付界面
    public function wechatScan($orderId)
    {
        $order = $this->orderService->findUser($orderId);

        // 需支付金额
        $needPaidTotal = $this->businessState->calculateOrderNeedPaidSum($order);

        $wechatData = $this->cacheService->get(get_cache_key(CacheConstant::WECHAT_PAY_SCAN_RETURN_DATA['name'], $order['order_id']));
        if (!$wechatData) {
            $this->orderService->cancel($order['id']);

            throw new ServiceException(__('错误'));
        }

        $qrcodeUrl = $wechatData['code_url'];

        $title = __('微信扫码支付');

        return v('frontend.order.wechat', compact('qrcodeUrl', 'order', 'needPaidTotal', 'title'));
    }

    // 微信jsapi支付
    public function wechatJSAPI(Request $request)
    {
        // 跳转地址
        $sUrl = $request->input('s_url');
        $fUrl = $request->input('f_url');

        $data = $request->input('data');
        if (!$data) {
            throw new ServiceException(__('参数错误'));
        }
        try {
            // 解密数据
            $decryptData = decrypt($data);
            // 获取orderId
            $orderId = $decryptData['order_id'];
        } catch (\Exception $e) {
            throw new ServiceException(__('参数错误'));
        }

        $openid = null;

        // 微信授权登录回调后
        if ($request->has('oauth')) {
            $user = Wechat::getInstance()->oauth->user();
            $openid = $user->getId();
            // 存储到session中
            session(['wechat_jsapi_openid' => $openid]);
        }

        $openid || $openid = session('wechat_jsapi_openid');
        if (!$openid) {
            // 微信授权登录获取openid
            $redirect = url_append_query(
                route('order.pay.wechat.jsapi', $orderId),
                [
                    'oauth' => 1,
                    'data' => $data,
                    's_url' => $sUrl,
                    'f_url' => $fUrl,
                ]
            );
            return Wechat::getInstance()->oauth->redirect($redirect);
        }

        // 订单
        $order = $this->orderService->findOrFail($orderId);

        // 创建微信支付订单
        /**
         * @var WechatJSAPI $jsapi
         */
        $jsapi = app()->make(WechatJSAPI::class);

        // 创建微信支付订单
        $data = $jsapi->createDirect($order, $openid);

        // 页面标题
        $title = __('微信JSAPI支付');

        return v('h5.order.wechat-jsapi-pay', compact('order', 'title', 'data'));
    }

    // 手动支付界面
    public function handPay(Request $request)
    {
        $data = $request->input('data');
        if (!$data) {
            throw new ServiceException(__('参数错误'));
        }
        try {
            // 解密数据
            $decryptData = decrypt($data);
            // 获取orderId
            $orderId = $decryptData['order_id'];
        } catch (\Exception $e) {
            throw new ServiceException(__('参数错误'));
        }

        // 订单
        $order = $this->orderService->findOrFail($orderId);
        // 需支付金额
        $needPaidTotal = $this->businessState->calculateOrderNeedPaidSum($order);

        // 手动支付内容
        $intro = $this->configService->getHandPayIntroducation();

        $title = __('手动打款支付');

        return v('frontend.order.hand_pay', compact('order', 'intro', 'needPaidTotal', 'title'));
    }
}
