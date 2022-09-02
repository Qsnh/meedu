<?php

/*
 * This file is part of the Qsnh/meedu.
 *
 * (c) 杭州白书科技有限公司
 */

namespace App\Events;

use Illuminate\Queue\SerializesModels;
use Illuminate\Foundation\Events\Dispatchable;

class UserVideoWatchedEvent
{
    use Dispatchable, SerializesModels;

    public $userId;
    public $videoId;

    /**
     * @param $userId
     * @param $videoId
     *
     * @codeCoverageIgnore
     */
    public function __construct($userId, $videoId)
    {
        $this->userId = $userId;
        $this->videoId = $videoId;
    }
}
