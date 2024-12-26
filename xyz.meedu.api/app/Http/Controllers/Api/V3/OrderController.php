<?php

/*
 * This file is part of the MeEdu.
 *
 * (c) 杭州白书科技有限公司
 */

namespace App\Http\Controllers\Api\V3;

use App\Bus\UniPayBus;
use App\Meedu\Hooks\HookRun;
use Illuminate\Http\Request;
use App\Constant\BusConstant;
use App\Meedu\Hooks\HookParams;
use App\Meedu\Hooks\Constant\PositionConstant;
use App\Http\Controllers\Api\V2\BaseController;
use App\Meedu\ServiceV2\Services\OrderServiceInterface;

class OrderController extends BaseController
{

    public function store(Request $request, OrderServiceInterface $orderService, UniPayBus $mobilePayBus)
    {
        $orderGoodsType = $request->input('goods_type');
        $orderGoodsId = max(0, (int)$request->input('goods_id'));
        $promoCode = $request->input('promo_code');
        if (!$orderGoodsType || !$orderGoodsId) {
            return $this->error(__('参数错误'));
        }

        $orderGoodsInfo = HookRun::run(
            PositionConstant::ORDER_STORE_INFO_PARSE,
            new HookParams([
                'goods_type' => $orderGoodsType,
                'goods_id' => $orderGoodsId,
            ])
        );

        if (!$orderGoodsInfo) {
            return $this->error(__('无法创建订单'));
        }

        $order = $orderService->createOrder($this->id(), $orderGoodsInfo, $promoCode);

        $data = [
            'order_no' => $order['order_id'],
            'total' => max(0, $order['charge'] - $order['discount']),
            'discount' => $order['discount'],
            'is_paid' => $order['status'] === BusConstant::ORDER_STATUS_SUCCESS,
        ];

        if (!$data['is_paid']) {
            $sign = $mobilePayBus->generateSign($order['id']);
            $data['pay_url'] = url_append_query(route('payment.index'), ['sign' => $sign]);
            $data['sign'] = $sign;
        }

        return $this->data($data);
    }

}
