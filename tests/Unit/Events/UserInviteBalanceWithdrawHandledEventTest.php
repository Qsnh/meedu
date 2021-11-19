<?php

/*
 * This file is part of the Qsnh/meedu.
 *
 * (c) 杭州白书科技有限公司
 */

namespace Tests\Unit\Events;

use Tests\TestCase;
use App\Services\Member\Models\User;
use Illuminate\Support\Facades\Auth;
use App\Events\UserInviteBalanceWithdrawHandledEvent;
use App\Services\Member\Models\UserInviteBalanceWithdrawOrder;
use App\Services\Member\Interfaces\NotificationServiceInterface;

class UserInviteBalanceWithdrawHandledEventTest extends TestCase
{
    public function test_run()
    {
        $user = User::factory()->create();
        $order = UserInviteBalanceWithdrawOrder::factory()->create(['user_id' => $user->id]);
        event(new UserInviteBalanceWithdrawHandledEvent([$order->id], $order->status));

        Auth::login($user);
        $count = $this->app->make(NotificationServiceInterface::class)->getUnreadCount($user['id']);
        $this->assertEquals(1, $count);
    }

    public function test_refund()
    {
        $user = User::factory()->create(['invite_balance' => 10]);
        $user1 = User::factory()->create(['invite_balance' => 12]);
        $user2 = User::factory()->create(['invite_balance' => 12]);
        $order = UserInviteBalanceWithdrawOrder::factory()->create([
            'user_id' => $user->id,
            'total' => 1,
            'status' => UserInviteBalanceWithdrawOrder::STATUS_FAILURE
        ]);
        $order1 = UserInviteBalanceWithdrawOrder::factory()->create([
            'user_id' => $user1->id,
            'total' => 2,
            'status' => UserInviteBalanceWithdrawOrder::STATUS_FAILURE
        ]);
        $order2 = UserInviteBalanceWithdrawOrder::factory()->create([
            'user_id' => $user1->id,
            'total' => 2,
            'status' => UserInviteBalanceWithdrawOrder::STATUS_SUCCESS
        ]);
        event(new UserInviteBalanceWithdrawHandledEvent([$order->id, $order1->id, $order2->id], UserInviteBalanceWithdrawOrder::STATUS_FAILURE));

        $user->refresh();
        $this->assertEquals(11, $user->invite_balance);

        $user1->refresh();
        $this->assertEquals(14, $user1->invite_balance);

        $user1->refresh();
        $this->assertEquals(12, $user2->invite_balance);
    }
}
