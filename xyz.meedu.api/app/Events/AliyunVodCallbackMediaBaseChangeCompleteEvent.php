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

class AliyunVodCallbackMediaBaseChangeCompleteEvent
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $videoId;
    public $videoName;

    public function __construct(string $videoId, string $videoName)
    {
        $this->videoId=$videoId;
        $this->videoName=$videoName;
    }
}
