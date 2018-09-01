<?php

namespace App\Meedu\Payment\Contract;

use App\Models\RechargePayment;

interface Payment
{

    /**
     * 创建订单
     * @param $data
     * @return PaymentStatus
     */
    public function create(RechargePayment $payment) : PaymentStatus;

    /**
     * 主动查询
     * @param $orderId
     * @return PaymentStatus
     */
    public function query(RechargePayment $payment) : PaymentStatus;

    /**
     * 回调
     * @param $data
     * @return PaymentStatus
     */
    public function callback();

}