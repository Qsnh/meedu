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
use App\Services\Member\Models\UserInviteBalanceRecord;
use App\Services\Member\Interfaces\UserInviteBalanceServiceInterface;

class UserInviteBalanceService implements UserInviteBalanceServiceInterface
{

    /**
     * @param int $page
     * @param int $pageSize
     * @return array
     */
    public function simplePaginate(int $page, int $pageSize): array
    {
        $query = UserInviteBalanceRecord::whereUserId(Auth::id())->latest();

        $total = $query->count();
        $list = $query->forPage($page, $pageSize)->get()->toArray();

        return compact('list', 'total');
    }

    /**
     * @param int $userId
     * @param int $reward
     */
    public function createInvite(int $userId, int $reward): void
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

    /**
     * @param int $userId
     * @param int $drawTotal
     * @param array $order
     */
    public function createOrderDraw(int $userId, int $drawTotal, array $order): void
    {
        if ($drawTotal == 0) {
            return;
        }
        UserInviteBalanceRecord::create([
            'user_id' => $userId,
            'type' => UserInviteBalanceRecord::TYPE_ORDER_DRAW,
            'total' => $drawTotal,
            'desc' => __('order draw', ['orderid' => $order['order_id']]),
        ]);
        User::find($userId)->increment('invite_balance', $drawTotal);
    }
}
