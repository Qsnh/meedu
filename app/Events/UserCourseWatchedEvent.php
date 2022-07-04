<?php

/*
 * This file is part of the Qsnh/meedu.
 *
 * (c) 杭州白书科技有限公司
 */

namespace App\Events;

use Illuminate\Queue\SerializesModels;
use Illuminate\Foundation\Events\Dispatchable;

class UserCourseWatchedEvent
{
    use Dispatchable, SerializesModels;

    public $userId;
    public $courseId;

    /**
     * @param $userId
     * @param $courseId
     *
     * @codeCoverageIgnore
     */
    public function __construct($userId, $courseId)
    {
        $this->userId = $userId;
        $this->courseId = $courseId;
    }
}
