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

class TencentVodCallbackTranscodeCompleteEvent
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $videoId;
    public $taskId;
    public $message;
    public $playSet;


    public function __construct(string $videoId, string $taskId, string $message, array $playSet)
    {
        $this->videoId = $videoId;
        $this->taskId = $taskId;
        $this->message = $message;
        $this->playSet = $playSet;
    }
}
