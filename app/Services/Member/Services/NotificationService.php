<?php

/*
 * This file is part of the Qsnh/meedu.
 *
 * (c) 杭州白书科技有限公司
 */

namespace App\Services\Member\Services;

use App\Services\Member\Models\User;
use App\Services\Member\Interfaces\NotificationServiceInterface;
use App\Services\Member\Notifications\SimpleMessageNotification;

class NotificationService implements NotificationServiceInterface
{

    /**
     * @param int $userId
     * @param int $credit1
     * @param string $message
     */
    public function notifyCredit1Message(int $userId, int $credit1, string $message): void
    {
        /**
         * @var User
         */
        $user = User::findOrFail($userId);
        $user->notify(new SimpleMessageNotification(sprintf(__('积分变动:%d，备注:%s'), $credit1, $message)));
    }

    /**
     * @param int $id
     * @param string $orderId
     */
    public function notifyOrderPaidMessage(int $id, string $orderId): void
    {
        /**
         * @var User
         */
        $user = User::findOrFail($id);
        $user->notify(new SimpleMessageNotification(__('订单:orderId已支付', ['orderId' => $orderId])));
    }

    /**
     * @param int $id
     */
    public function notifyRegisterMessage(int $id): void
    {
        $user = User::findOrFail($id);
        $user->notify(new SimpleMessageNotification(__('用户注册成功')));
    }

    /**
     * @param int $id
     */
    public function notifyBindMobileMessage(int $id): void
    {
        $user = User::findOrFail($id);
        $user->notify(new SimpleMessageNotification(__('请绑定手机号')));
    }

    /**
     * @param int $id
     * @param $status
     */
    public function notifyInviteBalanceWithdrawHandledMessage(int $id, $status): void
    {
        $user = User::findOrFail($id);
        $user->notify(new SimpleMessageNotification(__('邀请余额提现:status', ['status' => $status])));
    }

    /**
     * @param int $userId
     * @return int
     */
    public function getUnreadCount(int $userId): int
    {
        return User::find($userId)->unreadNotifications()->count();
    }

    /**
     * @param int $userId
     * @return int
     */
    public function getUserUnreadCount(int $userId): int
    {
        return User::findOrFail($userId)->unreadNotifications()->count();
    }

    /**
     * @param int $userId
     */
    public function markAllRead(int $userId): void
    {
        User::find($userId)->unreadNotifications->markAsRead();
    }
}
