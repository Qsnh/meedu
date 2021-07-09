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

class UserCourseWatchedEvent
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $userId;
    public $courseId;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct($userId, $courseId)
    {
        $this->userId = $userId;
        $this->courseId = $courseId;
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
