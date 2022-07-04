<?php

/*
 * This file is part of the Qsnh/meedu.
 *
 * (c) 杭州白书科技有限公司
 */

namespace App\Events;

use Illuminate\Queue\SerializesModels;
use Illuminate\Foundation\Events\Dispatchable;

class CourseCommentEvent
{
    use Dispatchable, SerializesModels;

    public $courseId;

    public $commentId;

    /**
     * CourseCommentEvent constructor.
     * @param int $courseId
     * @param int $commentId
     *
     * @codeCoverageIgnore
     */
    public function __construct(int $courseId, int $commentId)
    {
        $this->courseId = $courseId;
        $this->commentId = $commentId;
    }
}
