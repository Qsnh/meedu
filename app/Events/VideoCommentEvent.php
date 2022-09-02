<?php

/*
 * This file is part of the Qsnh/meedu.
 *
 * (c) 杭州白书科技有限公司
 */

namespace App\Events;

use Illuminate\Queue\SerializesModels;
use Illuminate\Foundation\Events\Dispatchable;

class VideoCommentEvent
{
    use Dispatchable, SerializesModels;

    public $videoId;

    public $commentId;

    /**
     * @param int $videoId
     * @param int $commentId
     *
     * @codeCoverageIgnore
     */
    public function __construct(int $videoId, int $commentId)
    {
        $this->videoId = $videoId;
        $this->commentId = $commentId;
    }
}
