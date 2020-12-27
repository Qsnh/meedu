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
use App\Constant\CacheConstant;
use App\Businesses\BusinessState;
use App\Exceptions\SystemException;
use App\Exceptions\ServiceException;
use App\Http\Controllers\Controller;
use App\Services\Base\Services\CacheService;
use App\Services\Base\Services\ConfigService;
use App\Services\Order\Services\OrderService;
use App\Services\Base\Interfaces\CacheServiceInterface;
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
    protected $businessState;
    /**
     * @var CacheService
     */
    protected $cacheService;

    public function __construct(
        OrderServiceInterface $orderService,
        ConfigServiceInterface $configService,
        BusinessState $businessState,
        CacheServiceInterface $cacheService
    ) {
        $this->orderService = $orderService;
        $this->configService = $configService;
        $this->businessState = $businessState;
        $this->cacheService = $cacheService;
    }

    /**
     * @param Request $request
     * @return mixed
     * @throws ServiceException
     * @throws SystemException
     * @throws \Illuminate\Contracts\Container\BindingResolutionException
     */
    public function pay(Request $request)
    {
        $orderId = $request->input('order_id');
        $order = $this->orderService->findUserNoPaid($orderId);

        $scene = $request->input('scene');
        $payment = $request->input('payment');
        if (!$payment) {
            throw new ServiceException(__('payment not exists'));
        }
        $payments = get_payments($scene);
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
        if ($createResult->status === false) {
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
        $needPaidTotal = $this->businessState->calculateOrderNeedPaidSum($order);

        $wechatData = $this->cacheService->get(get_cache_key(CacheConstant::WECHAT_PAY_SCAN_RETURN_DATA['name'], $order['order_id']));
        if (!$wechatData) {
            $this->orderService->cancel($order['id']);
            flash(__('error'));

            return redirect('/');
        }

        $qrcodeUrl = $wechatData['code_url'];

        $title = __('wechat.pay.page.title');

        return v('frontend.order.wechat', compact('qrcodeUrl', 'order', 'needPaidTotal', 'title'));
    }

    /**
     * @param $orderId
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function handPay($orderId)
    {
        $order = $this->orderService->findUser($orderId);
        $needPaidTotal = $this->businessState->calculateOrderNeedPaidSum($order);
        $intro = $this->configService->getHandPayIntroducation();

        $title = __('hand.pay.page.title');

        return v('frontend.order.hand_pay', compact('order', 'intro', 'needPaidTotal', 'title'));
    }
}
