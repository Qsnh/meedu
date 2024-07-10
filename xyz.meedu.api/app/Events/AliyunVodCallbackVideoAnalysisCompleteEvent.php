<?php

/*
 * This file is part of the MeEdu.
 *
 * (c) 杭州白书科技有限公司
 */

namespace App\Events;

use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;

class AliyunVodCallbackVideoAnalysisCompleteEvent
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $videoId;
    public $extra;
    public $duration;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct($videoId, int $duration, array $extra)
    {
        $this->videoId = $videoId;
        $this->extra = $extra;
        $this->duration = $duration;
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
