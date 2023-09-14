<?php

/*
 * This file is part of the MeEdu.
 *
 * (c) 杭州白书科技有限公司
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
        if ($this->courseService->isExistsCourseUserRecord($event->userId, $event->courseId) === false) {
            $this->courseService->createCourseUserRecord($event->userId, $event->courseId);
        }
        $this->courseService->setUserWatchedCourse($event->userId, $event->courseId);
    }
}
