<?php

/*
 * This file is part of the MeEdu.
 *
 * (c) 杭州白书科技有限公司
 */

namespace App\Events;

use Illuminate\Queue\SerializesModels;
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
    public function __construct(string $videoId, bool $isSuc, array $streams)
    {
        $this->videoId = $videoId;
        $this->isSuc = $isSuc;
        $this->streams = $streams;
    }
}
