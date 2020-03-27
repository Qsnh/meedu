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
use Illuminate\Support\Facades\Auth;
use App\Services\Base\Services\ConfigService;
use App\Services\Member\Services\UserService;
use App\Services\Order\Services\OrderService;
use App\Services\Order\Services\PromoCodeService;
use App\Services\Base\Interfaces\ConfigServiceInterface;
use App\Services\Member\Interfaces\UserServiceInterface;
use App\Services\Order\Interfaces\OrderServiceInterface;
use App\Services\Order\Interfaces\PromoCodeServiceInterface;

class BusinessState
{

    /**
     * @param array $user
     * @param array $course
     * @param array $video
     * @return bool
     * @throws \Illuminate\Contracts\Container\BindingResolutionException
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

    /**
     * @param array $user
     * @return bool
     */
    public function isRole(array $user): bool
    {
        if (!$user['role_id']) {
            return false;
        }
        if (!$user['role_expired_at']) {
            return false;
        }
        if (Carbon::now()->gt($user['role_expired_at'])) {
            return false;
        }
        return true;
    }

    /**
     * 是否可以生成邀请码
     *
     * @param array $user
     * @return bool
     * @throws \Illuminate\Contracts\Container\BindingResolutionException
     */
    public function canGenerateInviteCode(array $user): bool
    {
        /**
         * @var $configService ConfigService
         */
        $configService = app()->make(ConfigServiceInterface::class);
        /**
         * @var $promoCodeService PromoCodeService
         */
        $promoCodeService = app()->make(PromoCodeServiceInterface::class);
        $inviteConfig = $configService->getMemberInviteConfig();
        $isRole = $this->isRole($user);
        if ($inviteConfig['free_user_enabled'] == false && !$isRole) {
            // 开启了非会员无法生成优惠码
            return false;
        }
        $userPromoCode = $promoCodeService->userPromoCode();
        if ($userPromoCode) {
            // 已经生成
            return false;
        }
        return true;
    }

    /**
     * @param array $promoCode
     * @return bool
     * @throws \Illuminate\Contracts\Container\BindingResolutionException
     */
    public function promoCodeCanUse(array $promoCode): bool
    {
        // 自己不能使用自己的优惠码
        if ($promoCode['user_id'] === Auth::id()) {
            return false;
        }
        if ($promoCode['use_times'] > 0 && $promoCode['use_times'] - $promoCode['used_times'] <= 0) {
            // 使用次数已用完
            return false;
        }
        /**
         * @var $promoCodeService PromoCodeService
         */
        $promoCodeService = app()->make(PromoCodeServiceInterface::class);
        // 同一邀请码一个用户只能用一次
        $useRecords = $promoCodeService->getCurrentUserOrderPaidRecords($promoCode['id']);
        if ($useRecords) {
            return false;
        }
        // 非用户邀请优惠码可以多次使用
        if (!$this->isUserInvitePromoCode($promoCode['code'])) {
            return true;
        }
        /**
         * @var $userService UserService
         */
        $userService = app()->make(UserServiceInterface::class);
        $user = $userService->find(Auth::id());
        if ($user['invite_user_id']) {
            // 用户邀请优惠码只能使用一次
            return false;
        }
        return true;
    }

    /**
     * @param string $code
     * @return bool
     */
    public function isUserInvitePromoCode(string $code): bool
    {
        return strtolower($code[0]) === 'u';
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
        return $sum >= 0 ? $sum : 0;
    }

    /**
     * 是否购买了课程
     *
     * @param int $courseId
     * @return bool
     * @throws \Illuminate\Contracts\Container\BindingResolutionException
     */
    public function isBuyCourse(int $courseId): bool
    {
        if (!Auth::check()) {
            return false;
        }
        /**
         * @var $userService UserService
         */
        $userService = app()->make(UserServiceInterface::class);
        $user = $userService->find(Auth::id(), ['role']);
        if ($this->isRole($user)) {
            return true;
        }
        if ($userService->hasCourse($user['id'], $courseId)) {
            return true;
        }
        return false;
    }
}
