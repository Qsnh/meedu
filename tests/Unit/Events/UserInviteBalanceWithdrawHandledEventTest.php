<?php


namespace Tests\Unit\Events;


use App\Events\UserInviteBalanceWithdrawHandledEvent;
use App\Services\Member\Interfaces\NotificationServiceInterface;
use App\Services\Member\Models\User;
use App\Services\Member\Models\UserInviteBalanceWithdrawOrder;
use Illuminate\Support\Facades\Auth;
use Tests\TestCase;

class UserInviteBalanceWithdrawHandledEventTest extends TestCase
{

    public function test_run()
    {
        $user = factory(User::class)->create();
        $order = factory(UserInviteBalanceWithdrawOrder::class)->create(['user_id' => $user->id]);
        event(new UserInviteBalanceWithdrawHandledEvent([$order->id], $order->status));

        Auth::login($user);
        $count = $this->app->make(NotificationServiceInterface::class)->getUnreadCount();
        $this->assertEquals(1, $count);
    }

    public function test_refund()
    {
        $user = factory(User::class)->create(['invite_balance' => 10]);
        $user1 = factory(User::class)->create(['invite_balance' => 12]);
        $user2 = factory(User::class)->create(['invite_balance' => 12]);
        $order = factory(UserInviteBalanceWithdrawOrder::class)->create([
            'user_id' => $user->id,
            'total' => 1,
            'status' => UserInviteBalanceWithdrawOrder::STATUS_FAILURE
        ]);
        $order1 = factory(UserInviteBalanceWithdrawOrder::class)->create([
            'user_id' => $user1->id,
            'total' => 2,
            'status' => UserInviteBalanceWithdrawOrder::STATUS_FAILURE
        ]);
        $order2 = factory(UserInviteBalanceWithdrawOrder::class)->create([
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