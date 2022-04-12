<?php

/*
 * This file is part of the Qsnh/meedu.
 *
 * (c) 杭州白书科技有限公司
 */

namespace App\Http\Controllers\Backend\Api\V1;

use Carbon\Carbon;
use App\Bus\RefundBus;
use Illuminate\Http\Request;
use App\Events\OrderRefundCreated;
use Illuminate\Support\Facades\DB;
use App\Events\PaymentSuccessEvent;
use App\Services\Member\Models\User;
use App\Services\Order\Models\Order;
use App\Services\Order\Models\OrderGoods;
use App\Services\Order\Models\OrderRefund;
use App\Services\Order\Models\OrderPaidRecord;

class OrderController extends BaseController
{
    public function index(Request $request)
    {
        // 订单状态
        $status = (int)$request->input('status');
        // 订单创建用户
        $userId = $request->input('user_id');
        // 订单编号
        $orderId = $request->input('order_id');
        // 订单创建时间
        $createdAt = $request->input('created_at');
        // 商品id
        $goodsId = $request->input('goods_id');
        // 商品名
        $goodsName = trim($request->input('goods_name', ''));
        // 是否有退款
        $isRefund = (int)$request->input('is_refund');
        // 订单支付渠道[wechat:微信支付,alipay:支付宝支付]
        $payment = $request->input('payment');

        // 排序字段
        $sort = $request->input('sort', 'id');
        $order = $request->input('order', 'desc');

        $orderIds = [];
        if ($goodsId) {
            $orderIds = OrderGoods::query()->where('goods_id', $goodsId)->select(['oid'])->get()->pluck('oid')->toArray();
        }
        if ($goodsName) {
            $orderIds = array_merge(
                $orderIds,
                OrderGoods::query()->where('goods_name', $goodsName)->select(['oid'])->get()->pluck('oid')->toArray()
            );
        }
        $orderIds && $orderIds = array_flip(array_flip($orderIds));

        $query = Order::query()
            ->with([
                'goods:oid,goods_id,goods_type,goods_name,goods_thumb,goods_charge,goods_ori_charge',
                'paidRecords',
                'refund'
            ])
            ->when($payment, function ($query) use ($payment) {
                $payments = [$payment];
                if ($payment === 'wechat') {
                    $payments = array_merge($payments, ['wechat-jsapi', 'wechat_h5', 'wechatApp']);
                }
                $query->whereIn('payment', $payments);
            })
            ->when($goodsId || $goodsName, function ($query) use ($orderIds) {
                $query->whereIn('id', $orderIds ?: [0]);
            })
            ->when($userId, function ($query) use ($userId) {
                $query->where('user_id', $userId);
            })
            ->when($orderId, function ($query) use ($orderId) {
                $query->where('order_id', $orderId);
            })
            ->when($isRefund !== -1, function ($query) use ($isRefund) {
                $query->where('is_refund', $isRefund);
            })
            ->when($createdAt && is_array($createdAt), function ($query) use ($createdAt) {
                $query->whereBetween('created_at', $createdAt);
            });

        $orders = (clone $query)
            ->when($status, function ($query) use ($status) {
                $query->where('status', $status);
            })
            ->orderBy($sort, $order)
            ->paginate($request->input('size', 10));

        // 读取当前读取出来订单的用户
        $userIds = array_column($orders->items(), 'user_id');
        $users = User::query()
            ->select(['id', 'nick_name', 'avatar', 'mobile'])
            ->whereIn('id', $userIds)
            ->get()
            ->keyBy('id');

        // 各状态订单数量统计
        $countMap = [
            Order::STATUS_UNPAY => (clone $query)->where('status', Order::STATUS_UNPAY)->count(),
            Order::STATUS_CANCELED => (clone $query)->where('status', Order::STATUS_CANCELED)->count(),
            Order::STATUS_PAID => (clone $query)->where('status', Order::STATUS_PAID)->count(),
            Order::STATUS_PAYING => (clone $query)->where('status', Order::STATUS_PAYING)->count(),
        ];

        return $this->successData(compact('orders', 'users', 'countMap'));
    }

    public function detail($id)
    {
        $order = Order::query()
            ->with(['goods', 'paidRecords', 'refund'])
            ->where('id', $id)
            ->firstOrFail();

        $user = User::query()
            ->select(['id', 'nick_name', 'avatar', 'mobile'])
            ->where('id', $order['user_id'])
            ->first();

        return $this->successData([
            'order' => $order,
            'user' => $user,
        ]);
    }

    public function finishOrder($id)
    {
        $order = Order::query()->where('id', $id)->firstOrFail();
        event(new PaymentSuccessEvent($order->toArray()));
        return $this->success();
    }

    public function submitRefund(Request $request, $id)
    {
        // 退款金额
        // 前端传递的单位应该为：分
        $amount = (int)$request->input('amount');
        // 退款理由
        $reason = $request->input('reason') ?? '';
        // 是否本地退款订单[本地订单意味着就算是支付宝支付也不会去请求支付宝进行退款操作]
        $isLocal = (int)$request->input('is_local') ? 1 : 0;
        if (mb_strlen($reason) > 64) {
            return $this->error(__('参数错误'));
        }

        $order = Order::query()->where('id', $id)->firstOrFail();
        if (
            // 非本地退款订单
            $isLocal === 0 &&
            // 订单有退款记录
            $order['is_refund'] &&
            // 订单有最近退款时间
            $order['last_refund_at'] &&
            // 待处理订单最近退款时间距离当前时间必须超过30分钟
            (
                OrderRefund::query()->where('order_id', $order['id'])->where('status', OrderRefund::STATUS_DEFAULT)->exists() &&
                Carbon::parse($order['last_refund_at'])->addMinutes(30)->gt(Carbon::now())
            )
        ) {
            return $this->error(
                __(
                    '已有退款订单正在处理，请在[:date]之后再提交退款',
                    [
                        'date' => Carbon::parse($order['last_refund_at'])->addMinutes(30)->format('Y-m-d H:i:s')
                    ]
                )
            );
        }

        // 实际支付额度是否满足当前退款需求校验
        // 一个订单可能包括：实际支付+优惠码
        $directPayAmount = (int)OrderPaidRecord::query()
                ->where('order_id', $order['id'])
                ->where('paid_type', OrderPaidRecord::PAID_TYPE_DEFAULT)
                ->sum('paid_total') * 100;
        // 已申请退款额度，包括「处理中+已成功」
        // 数据库存储的单位是：分
        $refundTotalAmount = (int)OrderRefund::query()
            ->where('order_id', $order['id'])
            ->whereIn('status', [OrderRefund::STATUS_DEFAULT, OrderRefund::STATUS_SUCCESS])
            ->sum('amount');
        if ($directPayAmount < $refundTotalAmount + $amount) {
            return $this->error('超过订单实际支付额度');
        }

        DB::transaction(function () use ($amount, $reason, $isLocal, $directPayAmount, $order) {
            // 创建退款订单
            $refundData = [
                'order_id' => $order['id'],
                'user_id' => $order['user_id'],
                'payment' => $order['payment'],
                'total_amount' => $directPayAmount,
                'refund_no' => 'REFUND' . date('YmdHis') . mt_rand(0, 9),
                'amount' => $amount,
                'reason' => $reason,
                'is_local' => $isLocal,
                'status' => OrderRefund::STATUS_DEFAULT,
            ];
            if ($refundData['is_local'] === 1) {
                $refundData['status'] = OrderRefund::STATUS_SUCCESS;
                $refundData['success_at'] = Carbon::now()->toDateTimeLocalString();
            }

            $orderRefund = OrderRefund::create($refundData);

            // 如果是远程退款订单的话怎需要在这里提交处理了
            if ($isLocal === 0) {
                /**
                 * @var RefundBus $refundBus
                 */
                $refundBus = app()->make(RefundBus::class);
                $refundBus->handle(
                    $order->toArray(),
                    $orderRefund['refund_no'],
                    $orderRefund['total_amount'],
                    $orderRefund['amount'],
                    $orderRefund['reason']
                );
            }

            // 修改订单状态
            Order::query()
                ->where('id', $order['id'])
                ->update([
                    'is_refund' => 1,
                    'last_refund_at' => Carbon::now()->toDateTimeLocalString(),
                ]);

            // 退款订单已创建evt
            event(new OrderRefundCreated($orderRefund->toArray()));
        });

        return $this->successData();
    }

    public function refundOrders(Request $request)
    {
        // 订单支付渠道[wechat:微信支付,alipay:支付宝支付]
        $payment = $request->input('payment');
        // 状态
        $status = (int)$request->input('status');
        // 创建时间
        $createdAt = $request->input('created_at');
        // 是否本地订单[1:本地(仅记录),0:原渠道退回,-1:全部]
        $isLocal = (int)$request->input('is_local');
        // 用户手机号
        $mobile = $request->input('mobile');
        // 退款单号
        $refundNo = $request->input('refund_no');
        // 订单编号
        $orderNo = $request->input('order_no');

        $orders = OrderRefund::query()
            ->with(['order:id,order_id'])
            ->when($payment, function ($query) use ($payment) {
                $payments = [$payment];
                if ($payment === 'wechat') {
                    $payments = array_merge($payments, ['wechat-jsapi', 'wechat_h5', 'wechatApp']);
                }
                $query->whereIn('payment', $payments);
            })
            ->when($status, function ($query) use ($status) {
                $query->where('status', $status);
            })
            ->when($refundNo, function ($query) use ($refundNo) {
                $query->where('refund_no', $refundNo);
            })
            ->when($orderNo, function ($query) use ($orderNo) {
                $orderId = (int)Order::query()->where('order_id', $orderNo)->value('id');
                $query->where('order_id', $orderId);
            })
            ->when($mobile, function ($query) use ($mobile) {
                $userId = (int)User::query()->where('mobile', $mobile)->value('id');
                $query->where('user_id', $userId);
            })
            ->when($isLocal !== -1, function ($query) use ($isLocal) {
                $query->where('is_local', $isLocal);
            })
            ->when($createdAt && is_array($createdAt), function ($query) use ($createdAt) {
                $query->whereBetween('created_at', $createdAt);
            })
            ->orderByDesc('id')
            ->paginate($request->input('size', 10));

        $items = $orders->items();

        $userIds = array_column($items, 'user_id');
        if ($userIds) {
            $users = User::query()
                ->select(['id', 'mobile', 'nick_name', 'avatar'])
                ->whereIn('id', $userIds)
                ->get()
                ->keyBy('id')
                ->toArray();
            foreach ($items as $key => $item) {
                $items[$key]['user'] = $users[$item['user_id']] ?? [];
            }
        }

        return $this->successData([
            'data' => [
                'data' => $items,
                'total' => $orders->total(),
            ],
        ]);
    }

    public function deleteRefundOrder($id)
    {
        $refundOrder = OrderRefund::query()->where('id', $id)->firstOrFail();
        $orderAllRefundOrdersCount = (int)OrderRefund::query()->where('order_id', $refundOrder['order_id'])->count();
        DB::transaction(function () use ($refundOrder, $orderAllRefundOrdersCount) {
            // 删除退款订单
            $refundOrder->delete();

            // 如果是唯一的退款订单则修改原订单的退款状态
            if ($orderAllRefundOrdersCount === 1) {
                Order::query()
                    ->where('id', $refundOrder['order_id'])
                    ->update(['is_refund' => 0]);
            }
        });
        return $this->success();
    }
}
