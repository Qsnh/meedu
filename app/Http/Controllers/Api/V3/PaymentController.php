<?php

/*
 * This file is part of the MeEdu.
 *
 * (c) 杭州白书科技有限公司
 */

namespace App\Http\Controllers\Api\V3;

use Illuminate\Http\Request;
use App\Constant\FrontendConstant;
use App\Services\Order\Services\OrderService;
use App\Http\Controllers\Api\V2\BaseController;
use App\Services\Base\Interfaces\ConfigServiceInterface;
use App\Services\Order\Interfaces\OrderServiceInterface;

class PaymentController extends BaseController
{

    /**
     * @api {get} /api/v3/order/pay/handPay 手动打款支付
     * @apiGroup 订单-V3
     * @apiName OrderHandPay
     * @apiVersion v3.0.0
     * @apiHeader Authorization Bearer+空格+token
     *
     * @apiParam {String} order_id 订单编号
     *
     * @apiSuccess {Number} code 0成功,非0失败
     * @apiSuccess {Object} data 数据
     * @apiSuccess {String} data.text 手动打款支付信息
     */
    public function handPay(Request $request, OrderServiceInterface $orderService, ConfigServiceInterface $configService)
    {
        $orderId = $request->input('order_id');
        if (!$orderId) {
            return $this->error(__('参数错误'));
        }

        /**
         * @var OrderService $orderService
         */
        $order = $orderService->findUser($this->id(), $orderId);
        if (!$order['payment']) {
            // 如果未选择支付方式的话则改为线下打款打款支付
            $updateData = [
                'payment' => FrontendConstant::PAYMENT_SCENE_HAND_PAY,
                'payment_method' => FrontendConstant::PAYMENT_SCENE_HAND_PAY,
            ];
            $orderService->change2Paying($order['id'], $updateData);
        }

        $text = $configService->getHandPayIntroducation();

        return $this->data(['text' => $text]);
    }
}
