<?php

/*
 * This file is part of the Qsnh/meedu.
 *
 * (c) 杭州白书科技有限公司
 */

namespace App\Events;

use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;

class OrderRefundCreated
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $orderRefund;

    public function __construct(array $orderRefund)
    {
        $this->orderRefund = $orderRefund;
    }

    public function broadcastOn()
    {
        return new PrivateChannel('channel-name');
    }
}
