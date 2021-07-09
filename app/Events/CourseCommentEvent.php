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

class CourseCommentEvent
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $courseId;

    public $commentId;

    /**
     * CourseCommentEvent constructor.
     * @param int $courseId
     * @param int $commentId
     */
    public function __construct(int $courseId, int $commentId)
    {
        $this->courseId = $courseId;
        $this->commentId = $commentId;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     *
     * @codeCoverageIgnore
     */
    public function broadcastOn()
    {
        return new PrivateChannel('channel-name');
    }
}
