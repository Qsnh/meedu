<?php

/*
 * This file is part of the Qsnh/meedu.
 *
 * (c) XiaoTeng <616896861@qq.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace App\Listeners\UserInviteBalanceWithdrawHandledEvent;

use App\Constant\FrontendConstant;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Events\UserInviteBalanceWithdrawHandledEvent;
use App\Services\Member\Services\NotificationService;
use App\Services\Member\Services\UserInviteBalanceService;
use App\Services\Member\Interfaces\NotificationServiceInterface;
use App\Services\Member\Interfaces\UserInviteBalanceServiceInterface;

class NotifyListener implements ShouldQueue
{
    use InteractsWithQueue;

    /**
     * @var NotificationService
     */
    protected $notificationService;
    /**
     * @var UserInviteBalanceService
     */
    protected $inviteBalanceService;

    /**
     * NotifyListener constructor.
     * @param NotificationServiceInterface $notificationService
     * @param UserInviteBalanceServiceInterface $userInviteBalanceService
     */
    public function __construct(
        NotificationServiceInterface $notificationService,
        UserInviteBalanceServiceInterface $userInviteBalanceService
    ) {
        $this->notificationService = $notificationService;
        $this->inviteBalanceService = $userInviteBalanceService;
    }

    /**
     * Handle the event.
     *
     * @param UserInviteBalanceWithdrawHandledEvent $event
     * @return void
     */
    public function handle(UserInviteBalanceWithdrawHandledEvent $event)
    {
        $withdrawOrderIds = $event->ids;
        if (!$withdrawOrderIds) {
            return;
        }
        $orders = $this->inviteBalanceService->getOrdersList($withdrawOrderIds);
        $statusMap = [
            FrontendConstant::INVITE_BALANCE_WITHDRAW_STATUS_SUCCESS => __('success'),
            FrontendConstant::INVITE_BALANCE_WITHDRAW_STATUS_FAILURE => __('error'),
        ];
        foreach ($orders as $order) {
            $this->notificationService->notifyInviteBalanceWithdrawHandledMessage($order['user_id'], $statusMap[$order['status']] ?? '');
        }
    }
}
