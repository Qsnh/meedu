<?php

/*
 * This file is part of the Qsnh/meedu.
 *
 * (c) XiaoTeng <616896861@qq.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace App\Services\Member\Services;

use Carbon\Carbon;
use App\Services\Member\Models\UserVideo;
use App\Services\Member\Models\UserCourse;
use App\Services\Member\Interfaces\RoleServiceInterface;
use App\Services\Member\Interfaces\UserServiceInterface;
use App\Services\Member\Interfaces\DeliverServiceInterface;

class DeliverService implements DeliverServiceInterface
{
    protected $userService;
    protected $roleService;

    public function __construct(UserServiceInterface $userService, RoleServiceInterface $roleService)
    {
        $this->userService = $userService;
        $this->roleService = $roleService;
    }

    /**
     * 课程发货.
     *
     * @param int $userId
     * @param int $courseId
     * @param int $charge
     */
    public function deliverCourse(int $userId, int $courseId, int $charge): void
    {
        UserCourse::create([
            'user_id' => $userId,
            'course_id' => $courseId,
            'charge' => $charge,
            'created_at' => Carbon::now(),
        ]);
    }

    /**
     * 视频发货.
     *
     * @param int $userId
     * @param int $videoId
     * @param int $charge
     */
    public function deliverVideo(int $userId, int $videoId, int $charge): void
    {
        UserVideo::create([
            'user_id' => $userId,
            'video_id' => $videoId,
            'charge' => $charge,
            'created_at' => Carbon::now(),
        ]);
    }

    /**
     * 会员套餐发货.
     *
     * @param int $userId
     * @param int $roleId
     * @param int $charge
     */
    public function deliverRole(int $userId, int $roleId, int $charge): void
    {
        $user = $this->userService->find($userId, ['role']);
        $role = $this->roleService->find($roleId);

        $userRole = $user['role'] ?? [];
        if (!$userRole) {
            $this->roleService->userJoinRole($user, $role, $charge);

            return;
        }

        $this->roleService->userContinueRole($user, $role, $charge);
    }
}
