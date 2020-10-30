<?php

/*
 * This file is part of the Qsnh/meedu.
 *
 * (c) XiaoTeng <616896861@qq.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace App\Listeners\PaymentSuccessEvent;

use Carbon\Carbon;
use App\Events\PaymentSuccessEvent;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Services\Base\Services\ConfigService;
use App\Services\Member\Services\UserService;
use App\Services\Order\Services\OrderService;
use App\Services\Base\Interfaces\ConfigServiceInterface;
use App\Services\Member\Interfaces\UserServiceInterface;
use App\Services\Order\Interfaces\OrderServiceInterface;
use App\Services\Member\Services\UserInviteBalanceService;
use App\Services\Member\Interfaces\UserInviteBalanceServiceInterface;

class InviteUserRewardListener implements ShouldQueue
{
    use InteractsWithQueue;

    /**
     * @var UserService
     */
    protected $userService;
    /**
     * @var ConfigService
     */
    protected $configService;
    /**
     * @var UserInviteBalanceService
     */
    protected $userInviteBalanceService;

    /**
     * @var OrderService
     */
    protected $orderService;

    /**
     * InviteUserRewardListener constructor.
     * @param UserServiceInterface $userService
     * @param ConfigServiceInterface $configService
     * @param UserInviteBalanceServiceInterface $userInviteBalanceService
     * @param OrderServiceInterface $orderService
     */
    public function __construct(
        UserServiceInterface $userService,
        ConfigServiceInterface $configService,
        UserInviteBalanceServiceInterface $userInviteBalanceService,
        OrderServiceInterface $orderService
    ) {
        $this->userService = $userService;
        $this->userInviteBalanceService = $userInviteBalanceService;
        $this->configService = $configService;
        $this->orderService = $orderService;
    }

    /**
     * Handle the event.
     *
     * @param PaymentSuccessEvent $event
     * @return void
     */
    public function handle(PaymentSuccessEvent $event)
    {
        $orderUser = $this->userService->find($event->order['user_id']);
        if (!$orderUser['invite_user_id']) {
            // 非邀请用户
            return;
        }
        if (Carbon::now()->gt($orderUser['invite_user_expired_at'])) {
            // 邀请关系过期
            return;
        }
        $inviteConfig = $this->configService->getMemberInviteConfig();
        $perOrderDraw = $inviteConfig['per_order_draw'];
        if (!$perOrderDraw) {
            // 未设置抽成
            return;
        }
        $orderTotal = $this->orderService->getDirectPaidTotal($event->order['id']);
        $drawTotal = (int)($orderTotal * $perOrderDraw);
        if (!$drawTotal) {
            // 抽成少于一块钱
            return;
        }
        $this->userInviteBalanceService->createOrderDraw($orderUser['invite_user_id'], $drawTotal, $event->order);
    }
}
