<?php

/*
 * This file is part of the Qsnh/meedu.
 *
 * (c) 杭州白书科技有限公司
 */

namespace App\Http\Controllers\Api\V2;

use Illuminate\Http\Request;
use App\Constant\CacheConstant;
use App\Exceptions\SystemException;
use App\Services\Base\Services\CacheService;
use App\Services\Order\Services\OrderService;
use App\Services\Base\Interfaces\CacheServiceInterface;
use App\Services\Order\Interfaces\OrderServiceInterface;

class PaymentController extends BaseController
{

    /**
     * @var OrderService
     */
    protected $orderService;

    /**
     * @var CacheService
     */
    protected $cacheService;

    public function __construct(OrderServiceInterface $orderService, CacheServiceInterface $cacheService)
    {
        $this->orderService = $orderService;
        $this->cacheService = $cacheService;
    }

    /**
     * @api {post} /api/v2/order/payment/wechat/mini 微信小程序支付
     * @apiGroup 订单
     * @apiVersion v2.0.0
     *
     * @apiParam {String} openid openid
     * @apiParam {String} order_id 订单编号
     *
     * @apiSuccess {Number} code 0成功,非0失败
     * @apiSuccess {Object} data 数据
     * @apiSuccess {String} data.appId appId
     * @apiSuccess {String} data.nonceStr nonceStr
     * @apiSuccess {String} data.package package
     * @apiSuccess {String} data.paySign paySign
     * @apiSuccess {String} data.signType signType
     * @apiSuccess {String} data.timeStamp timeStamp
     */
    public function wechatMiniPay(Request $request)
    {
        $openid = $request->input('openid', '');
        $orderId = $request->input('order_id', '');
        $order = $this->orderService->findUser($orderId);

        $payments = get_payments('wechat_mini');
        if (!$payments) {
            return $this->error(__('错误'));
        }

        // 更新订单的支付方式
        $updateData = [
            'payment' => 'wechat',
            'payment_method' => 'miniapp',
        ];
        $this->orderService->change2Paying($order['id'], $updateData);
        $order = array_merge($order, $updateData);

        // 创建远程订单
        $paymentHandler = app()->make($payments['wechat']['handler']);
        $createResult = $paymentHandler->create($order, ['openid' => $openid]);
        if ($createResult->status == false) {
            throw new SystemException(__('系统错误'));
        }

        // 支付订单数据
        $data = $this->cacheService->get(get_cache_key(CacheConstant::WECHAT_PAY_SCAN_RETURN_DATA['name'], $order['order_id']), []);

        return $this->data($data);
    }

    /**
     * @api {get} /api/v2/order/payments 支付网关列表
     * @apiGroup 订单
     * @apiVersion v2.0.0
     *
     * @apiParam {String} scene 支付场景[h5,wechat]
     *
     * @apiSuccess {Number} code 0成功,非0失败
     * @apiSuccess {Object} data 数据
     * @apiSuccess {String} data.sign 网关值
     * @apiSuccess {String} data.name 网关名
     */
    public function payments(Request $request)
    {
        $scene = $request->input('scene', '');
        $payments = get_payments($scene)->map(function ($val) {
            return [
                'sign' => $val['sign'],
                'name' => $val['name'],
                'icon' => url($val['logo']),
            ];
        })->toArray();
        sort($payments);
        return $this->data($payments);
    }

    /**
     * @api {get} /api/v2/order/pay/redirect 跳转到第三方支付
     * @apiGroup 订单
     * @apiVersion v2.0.0
     *
     * @apiParam {String} payment_scene 支付场景[h5,wechat]
     * @apiParam {String} payment 支付网关
     * @apiParam {String} order_id 订单号
     *
     * @apiSuccess {Number} code 0成功,非0失败
     * @apiSuccess {Object} data 数据
     */
    public function payRedirect(Request $request)
    {
        $payment = $request->input('payment', '');
        $payemntScene = $request->input('payment_scene', '');

        $orderId = $request->input('order_id', '');
        $order = $this->orderService->findUser($orderId);

        $payments = get_payments($payemntScene);
        if (!$payments) {
            return $this->error(__('错误'));
        }
        if (!isset($payments[$payment])) {
            return $this->error(__('错误'));
        }
        $paymentMethod = $payments[$payment][$payemntScene];

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
        if ($createResult->status == false) {
            throw new SystemException(__('系统错误'));
        }

        return $createResult->data;
    }
}
