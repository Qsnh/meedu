<?php

/*
 * This file is part of the Qsnh/meedu.
 *
 * (c) XiaoTeng <616896861@qq.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace App\Repositories;

use Exception;
use App\Models\Order;
use App\Meedu\Payment\Youzan\Youzan;

class OrderRepository
{
    public function payInfo(Order $order): array
    {
        $remoteOrder = $order->remotePaymentOrders()->latest()->first();
        if (! $remoteOrder) {
            // 创建远程支付订单
            $result = (new Youzan())->create($order);
            if ($result->status === false) {
                throw new Exception('远程充值订单创建失败');
            }
            $pay = $result->data;

            return [
                'pay_url' => $pay['qr_url'],
                'pay_qr_code' => $pay['qr_code'],
            ];
        }

        $remoteData = json_decode($remoteOrder->create_data, true);

        return [
            'pay_url' => $remoteData['qr_url'],
            'pay_qr_code' => $remoteData['qr_code'],
        ];
    }
}
