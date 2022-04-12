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

class OrderRefundProcessed
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $orderRefund;
    public $status;
    public $extra;

    public function __construct(array $orderRefund, int $status, array $extra)
    {
        $this->orderRefund = $orderRefund;
        $this->status = $status;
        $this->extra = $extra;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        return new PrivateChannel('channel-name');
    }
}
