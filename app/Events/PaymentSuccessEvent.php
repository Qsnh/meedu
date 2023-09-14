<?php

/*
 * This file is part of the MeEdu.
 *
 * (c) 杭州白书科技有限公司
 */

namespace App\Events;

use Illuminate\Queue\SerializesModels;
use Illuminate\Foundation\Events\Dispatchable;

class PaymentSuccessEvent
{
    use Dispatchable, SerializesModels;

    public $order;

    /**
     * PaymentSuccessEvent constructor.
     *
     * @param array $order
     *
     * @codeCoverageIgnore
     */
    public function __construct(array $order)
    {
        $this->order = $order;
    }
}
