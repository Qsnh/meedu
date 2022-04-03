<?php

/*
 * This file is part of the Qsnh/meedu.
 *
 * (c) 杭州白书科技有限公司
 */

namespace App\Bus;

use Carbon\Carbon;
use Illuminate\Support\Facades\Log;
use App\Events\OrderRefundProcessed;
use App\Exceptions\ServiceException;
use App\Meedu\Payment\Alipay\AlipayRefund;
use App\Meedu\Payment\Wechat\WechatRefund;
use App\Services\Order\Models\OrderRefund;

class RefundBus
{
    public const ALIPAY_PAYMENT_SIGN = 'alipay';

    public const WECHAT_PAYMENT_WHITELIST = [
        'wechat',
        'wechat-jsapi',
        'wechat_h5',
        'wechatApp',
    ];

    public function handle(array $order, string $refundNo, int $total, int $amount, string $reason)
    {
        if ($order['payment'] === 'alipay') {
            $this->alipayHandle($order, $refundNo, $amount, $reason);
        } elseif (in_array($order['payment'], self::WECHAT_PAYMENT_WHITELIST)) {
            $this->wechatHandle($order, $refundNo, $total, $amount, $reason);
        } else {
            throw new ServiceException(__('当前订单不支持退款'));
        }
    }

    public function alipayHandle(array $order, string $refundNo, int $amount, string $reason)
    {
        /**
         * @var AlipayRefund $alipayRefund
         */
        $alipayRefund = app()->make(AlipayRefund::class);
        $alipayRefund->handle($refundNo, $order['order_id'], $amount, $reason);
    }

    public function wechatHandle(array $order, string $refundNo, int $total, int $amount, string $reason)
    {
        $extra = [];
        if ($order['payment_method'] === 'miniapp') {
            $extra['type'] = 'miniapp';
        } elseif ($order['payment'] === 'wechatApp') {
            $extra['type'] = 'app';
        }

        /**
         * @var WechatRefund $wechatRefund
         */
        $wechatRefund = app()->make(WechatRefund::class);
        $wechatRefund->handle($refundNo, $order['order_id'], $total, $amount, $reason, $extra);
    }

    /**
     * 判断给定的订单是否已经处理完成
     * @param $refundOrder
     * @return bool
     */
    public function isProcessed(array $refundOrder): bool
    {
        return in_array($refundOrder['status'], [OrderRefund::STATUS_SUCCESS, OrderRefund::STATUS_CLOSE, OrderRefund::STATUS_EXCEPTION]);
    }

    /**
     * 判断给定的状态是否为退款成功状态[这么做是将状态的判断内聚到当前处理类中]
     * @param int $status
     * @return bool
     */
    public function isSuccess(int $status): bool
    {
        return $status === OrderRefund::STATUS_SUCCESS;
    }

    /**
     * 微信退款订单的状态映射到本地的OrderRefund的状态码
     * @param string $refundStatus
     * @return int
     * @throws ServiceException
     */
    public function wechatRefundStatusMap(string $refundStatus): int
    {
        $map = [
            'SUCCESS' => OrderRefund::STATUS_SUCCESS,
            'CHANGE' => OrderRefund::STATUS_EXCEPTION,
            'REFUNDCLOSE' => OrderRefund::STATUS_CLOSE,
        ];
        if (isset($map[$refundStatus])) {
            return $map[$refundStatus];
        }
        throw new ServiceException(__('状态异常'));
    }

    /**
     * 退款订单查询并处理[如果状态发生改变]
     * @param array $orderRefund
     * @throws \Illuminate\Contracts\Container\BindingResolutionException
     */
    public function queryHandler(array $orderRefund): void
    {
        if ($orderRefund['is_local'] === 1) {
            return;
        }
        if ($orderRefund['payment'] === self::ALIPAY_PAYMENT_SIGN) {
            // 支付宝支付退款
            if (Carbon::parse($orderRefund['created_at'])->addMinutes(1)->gt(Carbon::now())) {
                // 退款订单提交到现在执行不超过1分钟
                // 跳过执行，等待下一次处理
                return;
            }
            /**
             * @var AlipayRefund $alipayRefund
             */
            $alipayRefund = app()->make(AlipayRefund::class);
            try {
                $isSuccess = $alipayRefund->queryIsSuccess($orderRefund['refund_no'], $orderRefund['order']['order_id']);
                event(new OrderRefundProcessed($orderRefund, $isSuccess ? OrderRefund::STATUS_SUCCESS : OrderRefund::STATUS_EXCEPTION, []));
            } catch (\Exception $e) {
                Log::error(
                    __METHOD__ . '|支付宝退款订单查询失败',
                    ['err' => $e->getMessage(), 'refund_no' => $orderRefund['refund_no']]
                );
            }
        } elseif (in_array($orderRefund['payment'], self::WECHAT_PAYMENT_WHITELIST)) {
            // 微信支付退款
            /**
             * @var WechatRefund $wechatRefund
             */
            $wechatRefund = app()->make(WechatRefund::class);
            try {
                $remoteStatus = $wechatRefund->queryStatus($orderRefund['refund_no']);
                $localStatus = $this->wechatRefundStatusMap($remoteStatus);
                if ($orderRefund['status'] !== $localStatus) {
                    // 状态发生了改变
                    event(new OrderRefundProcessed($orderRefund, $localStatus, []));
                }
            } catch (ServiceException $e) {
                Log::error(__METHOD__ . '|微信退款订单处理失败', ['err' => $e->getMessage()]);
            } catch (\Exception $e) {
                Log::error(
                    __METHOD__ . '|微信退款订单查询失败',
                    ['refund_no' => $orderRefund['refund_no'], 'err' => $e->getMessage()]
                );
            }
        }
    }
}
