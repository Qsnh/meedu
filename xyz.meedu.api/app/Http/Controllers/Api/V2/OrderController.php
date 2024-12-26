<?php

/*
 * This file is part of the MeEdu.
 *
 * (c) 杭州白书科技有限公司
 */

namespace App\Http\Controllers\Api\V2;

use Illuminate\Http\Request;
use App\Services\Order\Interfaces\OrderServiceInterface;

class OrderController extends BaseController
{


    /**
     * @api {get} /api/v2/order/status 订单状态查询
     * @apiGroup 订单
     * @apiName OrderStatusQuery
     * @apiVersion v2.0.0
     * @apiHeader Authorization Bearer+空格+token
     *
     * @apiParam {String} order_id 订单编号
     *
     * @apiSuccess {Number} code 0成功,非0失败
     * @apiSuccess {Object} data
     * @apiSuccess {Number} data.status 订单状态[1:未支付,5:支付中,9:已支付,7:已取消]
     */
    public function queryStatus(Request $request, OrderServiceInterface $orderService)
    {
        $orderId = $request->input('order_id');
        if (!$orderId) {
            return $this->error(__('参数错误'));
        }
        $order = $orderService->findUser($this->id(), $orderId);

        return $this->data([
            'status' => $order['status'],
        ]);
    }
}
