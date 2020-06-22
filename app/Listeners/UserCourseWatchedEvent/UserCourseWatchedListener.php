<?php

/*
 * This file is part of the Qsnh/meedu.
 *
 * (c) XiaoTeng <616896861@qq.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace App\Listeners\UserCourseWatchedEvent;

use App\Events\UserCourseWatchedEvent;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Services\Course\Services\CourseService;
use App\Services\Course\Interfaces\CourseServiceInterface;

class UserCourseWatchedListener implements ShouldQueue
{
    use InteractsWithQueue;

    /**
     * @var CourseService
     */
    protected $courseService;

    /**
     * UserCourseWatchedListener constructor.
     * @param CourseServiceInterface $courseService
     */
    public function __construct(CourseServiceInterface $courseService)
    {
        $this->courseService = $courseService;
    }

    /**
     * Handle the event.
     *
     * @param UserCourseWatchedEvent $event
     * @return void
     */
    public function handle(UserCourseWatchedEvent $event)
    {
        $this->courseService->setUserWatchedCourse($event->userId, $event->courseId);
    }
}
