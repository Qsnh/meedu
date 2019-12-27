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

use App\Services\Member\Models\User;
use Illuminate\Support\Facades\Auth;
use App\Services\Member\Interfaces\NotificationServiceInterface;
use App\Services\Member\Notifications\SimpleMessageNotification;

class NotificationService implements NotificationServiceInterface
{
    /**
     * @param int    $id
     * @param string $orderId
     */
    public function notifyOrderPaidMessage(int $id, string $orderId): void
    {
        /**
         * @var User
         */
        $user = User::findOrFail($id);
        $user->notify(new SimpleMessageNotification(__('notification_content_order_paid', ['orderId' => $orderId])));
    }

    /**
     * @return int
     */
    public function getUnreadCount(): int
    {
        return User::find(Auth::id())->unreadNotifications()->count();
    }
}
