<?php

/*
 * This file is part of the Qsnh/meedu.
 *
 * (c) XiaoTeng <616896861@qq.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace App\Http\Controllers\Frontend;

use Illuminate\Http\Request;
use App\Constant\FrontendConstant;
use App\Exceptions\SystemException;
use App\Exceptions\ServiceException;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Cache;
use App\Services\Base\Services\ConfigService;
use App\Services\Order\Services\OrderService;
use App\Services\Base\Interfaces\ConfigServiceInterface;
use App\Services\Order\Interfaces\OrderServiceInterface;

class OrderController extends Controller
{
    /**
     * @var OrderService
     */
    protected $orderService;
    /**
     * @var ConfigService
     */
    protected $configService;

    public function __construct(
        OrderServiceInterface $orderService,
        ConfigServiceInterface $configService
    ) {
        $this->orderService = $orderService;
        $this->configService = $configService;
    }

    public function show($orderId)
    {
        $order = $this->orderService->findUserNoPaid($orderId);

        $scene = is_h5() ? FrontendConstant::PAYMENT_SCENE_H5 : FrontendConstant::PAYMENT_SCENE_PC;
        is_wechat() && $scene = FrontendConstant::PAYMENT_SCENE_WECHAT_OPEN;

        $payments = get_payments($scene);

        return v('frontend.order.show', compact('order', 'payments'));
    }

    /**
     * @param Request $request
     * @param $orderId
     * @return mixed
     * @throws SystemException
     * @throws \App\Exceptions\ServiceException
     */
    public function pay(Request $request, $orderId)
    {
        $order = $this->orderService->findUserNoPaid($orderId);

        $scene = is_h5() ? FrontendConstant::PAYMENT_SCENE_H5 : FrontendConstant::PAYMENT_SCENE_PC;
        is_wechat() && $scene = FrontendConstant::PAYMENT_SCENE_WECHAT_OPEN;

        $payments = get_payments($scene);
        $payment = $order['payment'] ?: $request->post('payment');
        if (!$payment) {
            throw new ServiceException(__('payment not exists'));
        }
        $paymentMethod = $payments[$payment][$scene] ?? '';
        if (!$paymentMethod) {
            throw new SystemException(__('payment method not exists'));
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
        if ($createResult->status == false) {
            throw new SystemException(__('remote order create failed'));
        }

        return $createResult->data;
    }

    /**
     * @param Request $request
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function success(Request $request)
    {
        $orderId = $request->input('out_trade_no', '');
        $order = $this->orderService->findUser($orderId);

        return v('frontend.order.success', compact('order'));
    }

    /**
     * @param $orderId
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector|\Illuminate\View\View
     * @throws \App\Exceptions\ServiceException
     */
    public function wechat($orderId)
    {
        $order = $this->orderService->findUser($orderId);
        $wechatData = Cache::get(sprintf(config('cachekey.order.wechat_remote_order.name'), $order['order_id']));
        if (!$wechatData) {
            $this->orderService->cancel($order['id']);
            flash(__('error'));

            return redirect('/');
        }

        $qrcodeUrl = $wechatData['code_url'];

        return v('frontend.order.wechat', compact('qrcodeUrl', 'order'));
    }

    /**
     * @param $orderId
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function handPay($orderId)
    {
        $order = $this->orderService->findUser($orderId);
        $intro = $this->configService->getHandPayIntroducation();
        return v('frontend.order.hand_pay', compact('order', 'intro'));
    }
}
