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
use Illuminate\Support\Facades\DB;

class OrderRepository
{
    /**
     * 创建远程订单.
     *
     * @param Order  $order
     * @param string $payment
     *
     * @return bool|mixed
     */
    public function createRemoteOrder(Order $order, string $payment)
    {
        DB::beginTransaction();
        try {
            $payments = collect(config('meedu.payment'));

            // 保存用户选择的支付方式并更新状态
            $order->fill([
                'payment' => $payment,
                'payment_method' => $payments[$payment]['default_method'],
            ]);
            $order->save();

            // 创建对应的订单
            $paymentHandler = app()->make($payments[$payment]['handler']);
            $createResult = $paymentHandler->create($order);
            if ($createResult->status == false) {
                throw new Exception('远程支付订单创建失败');
            }

            // 保存用户选择的支付方式并更新状态
            $order->fill(['status' => Order::STATUS_PAYING]);
            $order->save();

            DB::commit();

            return $createResult->data;
        } catch (Exception $exception) {
            DB::rollBack();
            exception_record($exception);

            return false;
        }
    }
}
