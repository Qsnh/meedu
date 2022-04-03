<?php

/*
 * This file is part of the Qsnh/meedu.
 *
 * (c) 杭州白书科技有限公司
 */

namespace App\Bus;

use App\Exceptions\ServiceException;
use App\Meedu\Payment\Alipay\AlipayRefund;
use App\Meedu\Payment\Wechat\WechatRefund;
use App\Services\Order\Models\OrderRefund;

class RefundBus
{
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
     * @param $refundOrder
     * @return bool
     */
    public function isProcessed(array $refundOrder): bool
    {
        return in_array($refundOrder['status'], [OrderRefund::STATUS_SUCCESS, OrderRefund::STATUS_CLOSE, OrderRefund::STATUS_EXCEPTION]);
    }

    /**
     * @param int $status
     * @return bool
     */
    public function isSuccess(int $status): bool
    {
        return $status === OrderRefund::STATUS_SUCCESS;
    }

    /**
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
}
