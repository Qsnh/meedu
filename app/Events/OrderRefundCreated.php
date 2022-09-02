<?php

/*
 * This file is part of the Qsnh/meedu.
 *
 * (c) 杭州白书科技有限公司
 */

namespace App\Events;

use Illuminate\Queue\SerializesModels;
use Illuminate\Foundation\Events\Dispatchable;

class OrderRefundCreated
{
    use Dispatchable, SerializesModels;

    public $orderRefund;

    /**
     * @param array $orderRefund
     *
     * @codeCoverageIgnore
     */
    public function __construct(array $orderRefund)
    {
        $this->orderRefund = $orderRefund;
    }
}
