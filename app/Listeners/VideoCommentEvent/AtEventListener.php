<?php

/*
 * This file is part of the Qsnh/meedu.
 *
 * (c) XiaoTeng <616896861@qq.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace App\Listeners\VideoCommentEvent;

use App\Events\VideoCommentEvent;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Services\Member\Services\UserService;
use App\Services\Course\Services\VideoService;
use App\Services\Course\Services\VideoCommentService;
use App\Services\Member\Services\NotificationService;
use App\Services\Member\Interfaces\UserServiceInterface;
use App\Services\Course\Interfaces\VideoServiceInterface;
use App\Services\Course\Interfaces\VideoCommentServiceInterface;
use App\Services\Member\Interfaces\NotificationServiceInterface;

class AtEventListener implements ShouldQueue
{
    use InteractsWithQueue;

    /**
     * @var NotificationService
     */
    protected $notificationService;

    /**
     * @var UserService
     */
    protected $userService;

    /**
     * @var VideoService
     */
    protected $videoService;

    /**
     * @var VideoCommentService
     */
    protected $commentService;

    /**
     * AtEventListener constructor.
     * @param VideoCommentServiceInterface $commentService
     * @param NotificationServiceInterface $notificationService
     * @param UserServiceInterface $userService
     * @param VideoServiceInterface $videoService
     */
    public function __construct(
        VideoCommentServiceInterface $commentService,
        NotificationServiceInterface $notificationService,
        UserServiceInterface $userService,
        VideoServiceInterface $videoService
    ) {
        $this->commentService = $commentService;
        $this->notificationService = $notificationService;
        $this->userService = $userService;
        $this->videoService = $videoService;
    }

    /**
     * Handle the event.
     *
     * @param VideoCommentEvent $event
     * @return void
     */
    public function handle(VideoCommentEvent $event)
    {
        $comment = $this->commentService->find($event->commentId);
        $atUsers = get_at_users($comment['original_content']);
        if (!$atUsers) {
            return;
        }
        $users = $this->userService->getUsersInNicknames($atUsers);
        $video = $this->videoService->find($event->videoId);
        $link = route('course.show', ['id' => $video['id'], 'slug' => $video['slug']]);
        foreach ($atUsers as $atUserNickname) {
            $atUser = $users[$atUserNickname] ?? [];
            if (!$atUser) {
                continue;
            }
            $this->notificationService->notifyAtNotification(
                $comment['user_id'],
                $atUser['id'],
                $video['title'],
                $link
            );
        }
    }
}
