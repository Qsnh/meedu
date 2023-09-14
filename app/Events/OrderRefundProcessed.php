<?php

/*
 * This file is part of the MeEdu.
 *
 * (c) 杭州白书科技有限公司
 */

namespace App\Events;

use Illuminate\Queue\SerializesModels;
use Illuminate\Foundation\Events\Dispatchable;

class OrderRefundProcessed
{
    use Dispatchable, SerializesModels;

    public $orderRefund;
    public $status;
    public $extra;

    /**
     * @param array $orderRefund
     * @param int $status
     * @param array $extra
     * @codeCoverageIgnore
     */
    public function __construct(array $orderRefund, int $status, array $extra)
    {
        $this->orderRefund = $orderRefund;
        $this->status = $status;
        $this->extra = $extra;
    }
}
