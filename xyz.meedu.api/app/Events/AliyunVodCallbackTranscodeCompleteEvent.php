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

class AliyunVodCallbackTranscodeCompleteEvent
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $videoId;
    public $isSuc;

    public $streams;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct($videoId, bool $isSuc, array $streams)
    {
        $this->videoId = $videoId;
        $this->isSuc = $isSuc;
        $this->streams = $streams;
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
