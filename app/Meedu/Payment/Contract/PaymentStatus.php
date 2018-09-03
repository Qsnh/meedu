<?php

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