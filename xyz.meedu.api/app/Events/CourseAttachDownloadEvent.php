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

class CourseAttachDownloadEvent
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $attachId;
    public $courseId;
    public $userId;
    public $extra;

    /**
     * @param $userId
     * @param $courseId
     * @param $attachId
     * @param $extra
     */
    public function __construct($userId, $courseId, $attachId, $extra)
    {
        $this->userId = $userId;
        $this->attachId = $attachId;
        $this->courseId = $courseId;
        $this->extra = $extra;
    }
}
