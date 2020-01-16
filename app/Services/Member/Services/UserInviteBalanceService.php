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

use App\Exceptions\ServiceException;
use App\Services\Member\Models\User;
use Illuminate\Support\Facades\Auth;
use App\Events\UserInviteBalanceWithdrawCreatedEvent;
use App\Services\Member\Models\UserInviteBalanceRecord;
use App\Services\Member\Interfaces\UserServiceInterface;
use App\Services\Member\Models\UserInviteBalanceWithdrawOrder;
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
        app()->make(UserServiceInterface::class)->inviteBalanceInc($userId, $drawTotal);
    }

    /**
     * @param int $total
     * @param array $channel
     * @throws ServiceException
     */
    public function createCurrentUserWithdraw(int $total, array $channel): void
    {
        /**
         * @var UserService $userService
         */
        $userService = app()->make(UserServiceInterface::class);
        $user = $userService->currentUser();
        if ($user['invite_balance'] < $total) {
            throw new ServiceException(__('Insufficient invite balance'));
        }
        // 扣除余额
        $userService->inviteBalanceInc($user['id'], -$total);
        // 余额记录
        $order = UserInviteBalanceRecord::create([
            'user_id' => $user['id'],
            'type' => UserInviteBalanceRecord::TYPE_ORDER_WITHDRAW,
            'total' => -$total,
            'desc' => __('invite balance withdraw'),
        ]);
        // 创建提现订单
        UserInviteBalanceWithdrawOrder::create([
            'user_id' => $user['id'],
            'total' => $total,
            'before_balance' => $user['invite_balance'],
            'channel' => $channel['name'] ?? '',
            'channel_name' => $channel['username'] ?? '',
            'channel_account' => $channel['account'] ?? '',
            'channel_address' => $channel['address'] ?? '',
        ]);
        // event
        event(new UserInviteBalanceWithdrawCreatedEvent($user['id'], $order['id']));
    }

    /**
     * @param int $page
     * @param int $pageSize
     * @return array
     */
    public function currentUserOrderPaginate(int $page, int $pageSize): array
    {
        $query = UserInviteBalanceWithdrawOrder::whereUserId(Auth::id())->latest();

        $total = $query->count();
        $list = $query->forPage($page, $pageSize)->get()->toArray();

        return compact('list', 'total');
    }

    /**
     * @param array $ids
     * @return array
     */
    public function getOrdersList(array $ids): array
    {
        return UserInviteBalanceWithdrawOrder::whereIn('id', $ids)->get()->toArray();
    }

    /**
     * @param array $order
     */
    public function withdrawOrderRefund(array $order): void
    {
        // 余额记录
        UserInviteBalanceRecord::create([
            'user_id' => $order['user_id'],
            'type' => UserInviteBalanceRecord::TYPE_ORDER_WITHDRAW_BACK,
            'total' => $order['total'],
            'desc' => __('invite balance withdraw refund'),
        ]);
        // 扣除余额
        app()->make(UserServiceInterface::class)->inviteBalanceInc($order['user_id'], $order['total']);
    }
}
