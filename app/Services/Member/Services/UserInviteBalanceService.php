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
use App\Services\Member\Models\UserInviteBalanceRecord;
use App\Services\Member\Interfaces\UserInviteBalanceServiceInterface;

class UserInviteBalanceService implements UserInviteBalanceServiceInterface
{

    /**
     * @param int $userId
     * @param int $reward
     */
    public function createInvite(int $userId, int $reward)
    {
        if ($reward == 0) {
            return;
        }
        UserInviteBalanceRecord::create([
            'user_id' => $userId,
            'type' => UserInviteBalanceRecord::TYPE_DEFAULT,
            'total' => $reward,
            'desc' => __('invite reward'),
        ]);
        User::find($userId)->increment('invite_balance', $reward);
    }
}
