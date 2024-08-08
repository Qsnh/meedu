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

class AliyunVodCallbackAddLiveRecordVideoCompleteEvent
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $videoId;
    public $appName;
    public $streamName;
    public $domainName;
    public $recordStartTime;
    public $recordEndTime;

    public function __construct(
        string $videoId,
        string $appName,
        string $streamName,
        string $domainName,
        string $recordStartTime,
        string $recordEndTime
    ) {
        $this->videoId = $videoId;
        $this->appName = $appName;
        $this->streamName = $streamName;
        $this->domainName = $domainName;
        $this->recordStartTime = $recordStartTime;
        $this->recordEndTime = $recordEndTime;
    }
}
