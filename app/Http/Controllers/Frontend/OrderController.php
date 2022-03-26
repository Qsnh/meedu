<?php

/*
 * This file is part of the Qsnh/meedu.
 *
 * (c) 杭州白书科技有限公司
 */

namespace App\Http\Controllers\Frontend;

use App\Meedu\Wechat;
use Illuminate\Http\Request;
use App\Meedu\Payment\Wechat\WechatJSAPI;
use App\Services\Order\Services\OrderService;
use App\Services\Order\Interfaces\OrderServiceInterface;

class OrderController extends FrontendController
{
    /**
     * @var OrderService
     */
    protected $orderService;

    public function __construct(OrderServiceInterface $orderService)
    {
        parent::__construct();

        $this->orderService = $orderService;
    }

    public function wechatJSAPI(Request $request)
    {
        // 跳转地址
        $data = $request->input('data');

        $openid = session('wechat_jsapi_openid');
        if (!$openid) {
            // 微信授权登录回调后
            if ($request->has('oauth')) {
                $user = Wechat::getInstance()->oauth->user();
                $openid = $user->getId();
                // 存储到session中
                session(['wechat_jsapi_openid' => $openid]);
            }

            // 微信授权登录获取openid
            $redirect = url_append_query(
                route('order.pay.wechat.jsapi'),
                [
                    'oauth' => 1,
                    'data' => $data,
                ]
            );
            return Wechat::getInstance()->oauth->redirect($redirect);
        }

        try {
            // 解密数据
            $decryptData = decrypt($data);
            // 获取orderId
            $orderId = $decryptData['order_id'];
            $sUrl = $decryptData['s_url'];
            $fUrl = $decryptData['f_url'];

            if ($decryptData['expired_at'] < time()) {
                abort(500, __('参数错误'));
            }

            // 订单
            $order = $this->orderService->findOrFail($orderId);

            /**
             * @var WechatJSAPI $jsapi
             */
            $jsapi = app()->make(WechatJSAPI::class);

            // 创建微信支付订单
            $data = $jsapi->createDirect($order, $openid);

            // 页面标题
            $title = __('微信支付');

            return view('h5.order.wechat-jsapi-pay', compact('order', 'title', 'data', 'sUrl', 'fUrl'));
        } catch (\Exception $e) {
            abort(500, __('参数错误'));
        }
    }
}
