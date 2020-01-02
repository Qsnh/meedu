<?php

/*
 * This file is part of the Qsnh/meedu.
 *
 * (c) XiaoTeng <616896861@qq.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace App\Businesses;

use Carbon\Carbon;
use App\Constant\FrontendConstant;
use App\Services\Member\Services\UserService;
use App\Services\Member\Interfaces\UserServiceInterface;

class BusinessState
{

    /**
     * @param array $user
     * @param array $course
     * @param array $video
     * @return bool
     */
    public function canSeeVideo(array $user, array $course, array $video): bool
    {
        /**
         * @var $userService UserService
         */
        $userService = app()->make(UserServiceInterface::class);
        // 如果video的价格为0那么可以直接观看
        if ($video['charge'] == 0) {
            return true;
        }
        // 如果用户买了课程可以直接观看
        if ($userService->hasCourse($user['id'], $course['id'])) {
            return true;
        }
        // 如果用户买了当前视频可以直接观看
        if ($userService->hasVideo($user['id'], $video['id'])) {
            return true;
        }
        // 如果用户买了会员可以直接观看
        if ($user['role_id'] && Carbon::now()->lt($user['role_expired_at'])) {
            return true;
        }
        return false;
    }

    /**
     * 订单是否支付.
     *
     * @param array $order
     *
     * @return bool
     */
    public function orderIsPaid(array $order): bool
    {
        return $order['status'] == FrontendConstant::ORDER_PAID;
    }

    /**
     * 是否需要绑定手机号
     *
     * @param array $user
     * @return bool
     */
    public function isNeedBindMobile(array $user): bool
    {
        return substr($user['mobile'], 0, 1) != 1;
    }
}
