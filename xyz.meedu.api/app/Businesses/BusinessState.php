<?php

/*
 * This file is part of the MeEdu.
 *
 * (c) 杭州白书科技有限公司
 */

namespace App\Businesses;

use Carbon\Carbon;
use App\Exceptions\ServiceException;
use App\Services\Member\Services\UserService;
use App\Services\Order\Services\OrderService;
use App\Services\Order\Services\PromoCodeService;
use App\Services\Member\Interfaces\UserServiceInterface;
use App\Services\Order\Interfaces\OrderServiceInterface;
use App\Services\Course\Interfaces\CourseServiceInterface;
use App\Services\Order\Interfaces\PromoCodeServiceInterface;
use App\Services\Member\Interfaces\SocialiteServiceInterface;

class BusinessState
{

    public function canSeeVideo(array $user, array $course, array $video): bool
    {
        /**
         * @var CourseServiceInterface $courseService
         */
        $courseService = app()->make(CourseServiceInterface::class);
        $course = $courseService->find($course['id']);

        // 录播课设置免费的话可以直接看该录播课下所有视频
        if (1 === (int)$course['is_free']) {
            return true;
        }

        // 新增：如果课程设置为VIP免费且用户是有效VIP会员，可以直接观看
        if (1 === (int)$course['is_vip_free'] && $this->isRole($user)) {
            return true;
        }

        /**
         * @var UserService $userService
         */
        $userService = app()->make(UserServiceInterface::class);

        // 如果用户买了课程可以直接观看
        if ($userService->hasCourse($user['id'], $course['id'])) {
            return true;
        }

        // 如果用户买了会员可以直接观看（保留原有逻辑）
        if ($this->isRole($user)) {
            return true;
        }

        // 如果用户买了当前视频可以直接观看
        if ($userService->hasVideo($user['id'], $video['id'])) {
            return true;
        }

        return false;
    }

    /**
     * 是否需要绑定手机号
     *
     * @param array $user
     * @return bool
     */
    public function isNeedBindMobile(array $user): bool
    {
        return substr($user['mobile'], 0, 1) != 1 || mb_strlen($user['mobile']) !== 11;
    }

    /**
     * @param array $user
     * @return bool
     */
    public function isRole(array $user): bool
    {
        if (!$user['role_id'] || !$user['role_expired_at']) {
            return false;
        }
        return Carbon::now()->lt($user['role_expired_at']);
    }

    /**
     * @param int $loginUserId
     * @param array $promoCode
     * @return bool
     * @throws \Illuminate\Contracts\Container\BindingResolutionException
     */
    public function promoCodeCanUse(int $loginUserId, array $promoCode): bool
    {
        // 自己不能使用自己的优惠码
        if ($promoCode['user_id'] === $loginUserId) {
            return false;
        }
        // 使用次数已用完
        if ($promoCode['use_times'] > 0 && $promoCode['use_times'] - $promoCode['used_times'] <= 0) {
            return false;
        }
        // 是否过期
        if ($promoCode['expired_at'] && Carbon::now()->gt($promoCode['expired_at'])) {
            return false;
        }
        /**
         * @var $promoCodeService PromoCodeService
         */
        $promoCodeService = app()->make(PromoCodeServiceInterface::class);
        // 同一邀请码一个用户只能用一次
        $useRecords = $promoCodeService->getCurrentUserOrderPaidRecords($loginUserId, $promoCode['id']);
        if ($useRecords) {
            return false;
        }
        return true;
    }

    /**
     * @param array $order
     * @return int
     * @throws \Illuminate\Contracts\Container\BindingResolutionException
     */
    public function calculateOrderNeedPaidSum(array $order): int
    {
        /**
         * @var $orderService OrderService
         */
        $orderService = app()->make(OrderServiceInterface::class);
        $sum = $order['charge'] - $orderService->getOrderPaidRecordsTotal($order['id']);
        return max($sum, 0);
    }

    /**
     * 是否购买了课程
     *
     * @param integer $userId
     * @param integer $courseId
     * @return boolean
     */
    public function isBuyCourse(int $userId, int $courseId): bool
    {
        /**
         * @var CourseServiceInterface $courseService
         */
        $courseService = app()->make(CourseServiceInterface::class);
        $course = $courseService->find($courseId);

        // 课程设置为免费
        if (1 === $course['is_free']) {
            return true;
        }

        /**
         * @var $userService UserService
         */
        $userService = app()->make(UserServiceInterface::class);
        $user = $userService->find($userId, ['role']);

        if (1 === $course['is_vip_free'] && $this->isRole($user)) {
            return true;
        }

        // 用户购买了课程
        if ($userService->hasCourse($user['id'], $courseId)) {
            return true;
        }

        return false;
    }

    public function socialiteBindCheck(int $userId, string $app, string $appId): void
    {
        /**
         * @var SocialiteServiceInterface $socialiteService
         */
        $socialiteService = app()->make(SocialiteServiceInterface::class);

        $hasBindSocialites = $socialiteService->userSocialites($userId);
        if (in_array($app, array_column($hasBindSocialites, 'app'))) {
            throw new ServiceException(__('您已经绑定了该渠道的账号'));
        }

        // 读取当前社交账号绑定的用户id
        if ($socialiteService->getBindUserId($app, $appId)) {
            throw new ServiceException(__('当前渠道账号已绑定了其它账号'));
        }
    }
}
