<?php

/*
 * This file is part of the Qsnh/meedu.
 *
 * (c) XiaoTeng <616896861@qq.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace App\Events;

use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;

class VideoCommentEvent
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $videoId;

    public $commentId;

    /**
     * CourseCommentEvent constructor.
     * @param int $videoId
     * @param int $commentId
     */
    public function __construct(int $videoId, int $commentId)
    {
        $this->videoId = $videoId;
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
