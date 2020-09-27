<?php

/*
 * This file is part of the Qsnh/meedu.
 *
 * (c) XiaoTeng <616896861@qq.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
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
     * @OA\Post(
     *     path="/order/payment/wechat/mini",
     *     summary="小程序支付",
     *     tags={"支付"},
     *     @OA\RequestBody(description="",@OA\JsonContent(
     *         @OA\Property(property="openid",description="openid",type="string"),
     *         @OA\Property(property="order_id",description="订单编号",type="string"),
     *     )),
     *     @OA\Response(
     *         description="",response=200,
     *         @OA\JsonContent(
     *             @OA\Property(property="code",type="integer",description="状态码"),
     *             @OA\Property(property="message",type="string",description="消息"),
     *             @OA\Property(property="data",type="object",description="",
     *                 @OA\Property(property="appId",type="string",description="appId"),
     *                 @OA\Property(property="nonceStr",type="string",description="nonceStr"),
     *                 @OA\Property(property="package",type="string",description="package"),
     *                 @OA\Property(property="paySign",type="string",description="paySign"),
     *                 @OA\Property(property="signType",type="string",description="signType"),
     *                 @OA\Property(property="timeStamp",type="string",description="timeStamp"),
     *             ),
     *         )
     *     )
     * )
     *
     * @return \Illuminate\Http\JsonResponse
     * @throws SystemException
     * @throws \App\Exceptions\ServiceException
     */
    public function wechatMiniPay(Request $request)
    {
        $openid = $request->input('openid', '');
        $orderId = $request->input('order_id', '');
        $order = $this->orderService->findUser($orderId);

        $payments = get_payments('wechat_mini');
        if (!$payments) {
            return $this->error(__('error'));
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
            throw new SystemException(__('remote order create failed'));
        }

        // 支付订单数据
        $data = $this->cacheService->get(get_cache_key(CacheConstant::WECHAT_PAY_SCAN_RETURN_DATA['name'], $order['order_id']), []);

        return $this->data($data);
    }

    /**
     * @OA\Get(
     *     path="/order/payments",
     *     summary="支付网关",
     *     tags={"支付"},
     *     @OA\Parameter(in="query",name="scene",description="支付场景，h5,wechat",required=true,@OA\Schema(type="string")),
     *     @OA\Response(
     *         description="",response=200,
     *         @OA\JsonContent(
     *             @OA\Property(property="code",type="integer",description="状态码"),
     *             @OA\Property(property="message",type="string",description="消息"),
     *             @OA\Property(property="data",type="object",description="",
     *                 @OA\Property(property="sign",type="string",description="sign"),
     *                 @OA\Property(property="name",type="string",description="支付网关名"),
     *             ),
     *         )
     *     )
     * )
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
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
     * @OA\Get(
     *     path="/order/pay/redirect",
     *     summary="支付(跳转)",
     *     tags={"支付"},
     *     @OA\Parameter(in="query",name="payment_scene",description="支付场景，如：h5,wechat",required=true,@OA\Schema(type="string")),
     *     @OA\Parameter(in="query",name="payment",description="支付网关",required=true,@OA\Schema(type="string")),
     *     @OA\Parameter(in="query",name="order_id",description="订单号",required=true,@OA\Schema(type="string")),
     *     @OA\Response(
     *         description="",response=200,
     *         @OA\JsonContent(
     *             @OA\Property(property="code",type="integer",description="状态码"),
     *             @OA\Property(property="message",type="string",description="消息"),
     *             @OA\Property(property="data",type="object",description="data"),
     *         )
     *     )
     * )
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function payRedirect(Request $request)
    {
        $payment = $request->input('payment', '');
        $payemntScene = $request->input('payment_scene', '');

        $orderId = $request->input('order_id', '');
        $order = $this->orderService->findUser($orderId);

        $payments = get_payments($payemntScene);
        if (!$payments) {
            return $this->error(__('error'));
        }
        if (!isset($payments[$payment])) {
            return $this->error(__('error'));
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
            throw new SystemException(__('remote order create failed'));
        }

        return $createResult->data;
    }
}
