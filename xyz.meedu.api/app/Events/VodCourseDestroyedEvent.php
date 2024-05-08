<?php

/*
 * This file is part of the MeEdu.
 *
 * (c) 杭州白书科技有限公司
 */

namespace App\Events;

use Illuminate\Queue\SerializesModels;
use Illuminate\Foundation\Events\Dispatchable;

class VodCourseDestroyedEvent
{
    use Dispatchable, SerializesModels;

    public $id;

    /**
     * @param $courseId
     *
     * @codeCoverageIgnore
     */
    public function __construct($courseId)
    {
        $this->id = $courseId;
    }
}
