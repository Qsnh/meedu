<?php

/*
 * This file is part of the Qsnh/meedu.
 *
 * (c) XiaoTeng <616896861@qq.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace App\Listeners\CourseCommentEvent;

use App\Events\CourseCommentEvent;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Services\Member\Services\UserService;
use App\Services\Course\Services\CourseService;
use App\Services\Member\Services\NotificationService;
use App\Services\Course\Services\CourseCommentService;
use App\Services\Member\Interfaces\UserServiceInterface;
use App\Services\Course\Interfaces\CourseServiceInterface;
use App\Services\Member\Interfaces\NotificationServiceInterface;
use App\Services\Course\Interfaces\CourseCommentServiceInterface;

class AtEventListener implements ShouldQueue
{
    use InteractsWithQueue;

    /**
     * @var CourseCommentService
     */
    public $commentService;

    /**
     * @var NotificationService
     */
    protected $notificationService;

    /**
     * @var UserService
     */
    protected $userService;

    /**
     * @var CourseService
     */
    protected $courseService;

    /**
     * AtEventListener constructor.
     * @param CourseCommentServiceInterface $commentService
     * @param NotificationServiceInterface $notificationService
     * @param UserServiceInterface $userService
     * @param CourseServiceInterface $courseService
     */
    public function __construct(
        CourseCommentServiceInterface $commentService,
        NotificationServiceInterface $notificationService,
        UserServiceInterface $userService,
        CourseServiceInterface $courseService
    ) {
        $this->commentService = $commentService;
        $this->notificationService = $notificationService;
        $this->userService = $userService;
        $this->courseService = $courseService;
    }

    /**
     * Handle the event.
     *
     * @param CourseCommentEvent $event
     * @return void
     */
    public function handle(CourseCommentEvent $event)
    {
        $comment = $this->commentService->find($event->commentId);
        $atUsers = get_at_users($comment['original_content']);
        if (!$atUsers) {
            return;
        }
        $users = $this->userService->getUsersInNicknames($atUsers);
        $course = $this->courseService->find($event->courseId);
        $link = route('course.show', ['id' => $course['id'], 'slug' => $course['slug']]);
        foreach ($atUsers as $atUserNickname) {
            $atUser = $users[$atUserNickname] ?? [];
            if (!$atUser) {
                continue;
            }
            $this->notificationService->notifyAtNotification(
                $comment['user_id'],
                $atUser['id'],
                $course['title'],
                $link
            );
        }
    }
}
