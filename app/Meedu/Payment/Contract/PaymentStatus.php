<?php

/*
 * This file is part of the MeEdu.
 *
 * (c) 杭州白书科技有限公司
 */

namespace App\Meedu\Payment\Contract;

class PaymentStatus
{
    public $status;

    public $data;

    public $message;

    public function __construct(bool $status = false, $data = [], $message = '')
    {
        $this->status = $status;
        $this->data = $data;
        $this->message = $message;
    }
}
