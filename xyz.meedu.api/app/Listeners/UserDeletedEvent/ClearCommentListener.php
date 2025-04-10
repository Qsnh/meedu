<?php

/*
 * This file is part of the MeEdu.
 *
 * (c) 杭州白书科技有限公司
 */

namespace App\Listeners\UserDeletedEvent;

use App\Events\UserDeletedEvent;
use App\Meedu\ServiceV2\Services\CommentServiceInterface;

class ClearCommentListener
{

    private $commentService;

    public function __construct(CommentServiceInterface $commentService)
    {
        $this->commentService = $commentService;
    }

    /**
     * Handle the event.
     *
     * @param  \App\Events\UserDeletedEvent  $event
     * @return void
     */
    public function handle(UserDeletedEvent $event)
    {
        $this->commentService->deleteUserDATA($event->userId);
    }
}
