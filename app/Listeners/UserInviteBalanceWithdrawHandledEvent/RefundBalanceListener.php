<?php

/*
 * This file is part of the Qsnh/meedu.
 *
 * (c) 杭州白书科技有限公司
 */

namespace App\Listeners\UserInviteBalanceWithdrawHandledEvent;

use App\Constant\FrontendConstant;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Events\UserInviteBalanceWithdrawHandledEvent;
use App\Services\Member\Services\UserInviteBalanceService;
use App\Services\Member\Interfaces\UserInviteBalanceServiceInterface;

class RefundBalanceListener implements ShouldQueue
{
    use InteractsWithQueue;

    /**
     * @var UserInviteBalanceService
     */
    protected $inviteBalanceService;

    /**
     * RefundBalanceListener constructor.
     * @param UserInviteBalanceServiceInterface $userInviteBalanceService
     */
    public function __construct(UserInviteBalanceServiceInterface $userInviteBalanceService)
    {
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
        if ($event->status != FrontendConstant::INVITE_BALANCE_WITHDRAW_STATUS_FAILURE) {
            return;
        }
        // 返回余额
        $orders = $this->inviteBalanceService->getOrdersList($event->ids);
        foreach ($orders as $order) {
            if ($order['status'] != FrontendConstant::INVITE_BALANCE_WITHDRAW_STATUS_FAILURE) {
                continue;
            }
            $this->inviteBalanceService->withdrawOrderRefund($order);
        }
    }
}
