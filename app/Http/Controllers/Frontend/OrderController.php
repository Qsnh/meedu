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
use App\Exceptions\ServiceException;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Cache;
use App\Services\Base\Services\ConfigService;
use App\Services\Order\Services\OrderService;

class OrderController extends Controller
{
    protected $orderService;
    protected $configService;

    public function __construct(
        OrderService $orderService,
        ConfigService $configService
    ) {
        $this->orderService = $orderService;
        $this->configService = $configService;
    }

    public function show($orderId)
    {
        $order = $this->orderService->findNoPaid($orderId);
        $payments = get_payments(FrontendConstant::PAYMENT_SCENE_PC);

        return v('frontend.order.show', compact('order', 'payments'));
    }

    /**
     * @param Request $request
     * @param $orderId
     *
     * @return mixed
     *
     * @throws ServiceException
     */
    public function pay(Request $request, $orderId)
    {
        $order = $this->orderService->findNoPaid($orderId);

        $payments = get_payments(FrontendConstant::PAYMENT_SCENE_PC);
        $payment = $order['payment'] ?: $request->post('payment');
        $paymentMethod = $payments[$payment][FrontendConstant::PAYMENT_SCENE_PC] ?? '';
        if (! $paymentMethod) {
            throw new ServiceException(__('payment method not exists'));
        }

        // 创建远程订单
        $paymentHandler = app()->make($payments[$payment]['handler']);
        $createResult = $paymentHandler->create($order);
        if ($createResult->status == false) {
            throw new ServiceException(__('remote order create failed'));
        }

        // 更新订单的支付方式
        $updateData = [
            'payment' => $payment,
            'payment_method' => $paymentMethod,
        ];
        $this->orderService->change2Paying($order['id'], $updateData);

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
        $order = $this->orderService->find($orderId);

        return v('frontend.order.success', compact('order'));
    }

    /**
     * @param $orderId
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector|\Illuminate\View\View
     */
    public function wechat($orderId)
    {
        $order = $this->orderService->find($orderId);
        $wechatData = Cache::get(sprintf(config('cachekey.order.wechat_remote_order.name'), $order['order_id']));
        if (! $wechatData) {
            $this->orderService->cancel($order['id']);
            flash(__('error'));

            return redirect('/');
        }

        $qrcodeUrl = $wechatData['code_url'];

        return v('frontend.order.wechat', compact('qrcodeUrl', 'order'));
    }
}
