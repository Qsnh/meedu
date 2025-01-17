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

    /**
     * @api {post} /api/v3/order [V3]订单-创建
     * @apiGroup 订单支付模块
     * @apiName OrderStoreV3
     *
     * @apiParam {String=COURSE,ROLE,学习路径,BOOK,文章,秒杀,试卷,模拟试卷,练习,课程团购,直播课程} goods_type 商品类型
     * @apiParam {Number} goods_id 商品ID
     * @apiParam {String} promo_code 优惠码
     *
     * @apiSuccess {Number} code 0成功,非0失败
     * @apiSuccess {Object} data
     * @apiSuccess {String} data.order_no 订单编号
     * @apiSuccess {Number} data.total 订单总价,单位:元
     * @apiSuccess {Number} data.discount 订单优惠额,单位:元
     * @apiSuccess {Boolean} data.is_paid 是否支付
     * @apiSuccess {String} data.pay_url 支付URL.PC请根据此URL生成二维码,H5请直接跳转到此地址支付
     * @apiSuccess {String} data.sign 随机码.用此码查询订单支付结果
     */
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
