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

class TencentVodCallbackFileDeletedEvent
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $videoIds;

    public function __construct(array $videoIds)
    {
        $this->videoIds = $videoIds;
    }
}
