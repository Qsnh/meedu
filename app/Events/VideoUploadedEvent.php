<?php

/*
 * This file is part of the Qsnh/meedu.
 *
 * (c) 杭州白书科技有限公司
 */

namespace App\Events;

use Illuminate\Queue\SerializesModels;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;

class VideoUploadedEvent
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $fileId;
    public $service;
    public $from;
    public $fromId;

    /**
     * @param $fileId
     * @param $service
     * @param $from
     * @param $fromId
     *
     * @codeCoverageIgnore
     */
    public function __construct($fileId, $service, $from, $fromId)
    {
        $this->fileId = $fileId;
        $this->service = $service;
        $this->from = $from;
        $this->fromId = $fromId;
    }
}
