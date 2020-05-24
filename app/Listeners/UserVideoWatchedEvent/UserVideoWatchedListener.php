<?php

/*
 * This file is part of the Qsnh/meedu.
 *
 * (c) XiaoTeng <616896861@qq.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace App\Listeners\UserVideoWatchedEvent;

use App\Events\UserVideoWatchedEvent;
use App\Events\UserCourseWatchedEvent;
use App\Services\Member\Services\UserService;
use App\Services\Course\Services\VideoService;
use App\Services\Course\Services\CourseService;
use App\Services\Member\Interfaces\UserServiceInterface;
use App\Services\Course\Interfaces\VideoServiceInterface;
use App\Services\Course\Interfaces\CourseServiceInterface;

class UserVideoWatchedListener
{

    /**
     * @var CourseService
     */
    protected $courseService;

    /**
     * @var VideoService
     */
    protected $videoService;

    /**
     * @var UserService
     */
    protected $userService;

    /**
     * UserVideoWatchedListener constructor.
     * @param CourseServiceInterface $courseService
     * @param VideoServiceInterface $videoService
     * @param UserServiceInterface $userService
     */
    public function __construct(
        CourseServiceInterface $courseService,
        VideoServiceInterface $videoService,
        UserServiceInterface $userService
    ) {
        $this->courseService = $courseService;
        $this->videoService = $videoService;
        $this->userService = $userService;
    }

    /**
     * Handle the event.
     *
     * @param UserVideoWatchedEvent $event
     * @return void
     */
    public function handle(UserVideoWatchedEvent $event)
    {
        $video = $this->videoService->find($event->videoId);

        // 检测课程下的视频是否全部观看，全部观看完的话触发课程观看完成事件
        $courseVideos = $this->videoService->getCourseList([$video['course_id']]);
        $courseVideoIds = array_column($courseVideos, 'id');
        $recordVideos = $this->userService->getUserVideoWatchRecords($event->userId, $video['course_id']);
        $recordVideoIds = array_column($recordVideos, 'video_id');
        $diff = array_diff($courseVideoIds, $recordVideoIds);

        // 课程进度计算

        if (!$diff) {
            // 全部看完
            event(new UserCourseWatchedEvent($event->userId, $video['course_id']));
        } else {
            $progress = (int) (round(count($recordVideoIds) / count($courseVideoIds), 2) * 100);
            $this->courseService->setUserWatchProgress($event->userId, $video['course_id'], $progress);
        }
    }
}
