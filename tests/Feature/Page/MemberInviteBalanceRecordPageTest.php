<?php


namespace Tests\Feature\Page;


use App\Services\Member\Models\User;
use App\Services\Member\Models\UserInviteBalanceRecord;
use Tests\TestCase;

class MemberInviteBalanceRecordPageTest extends TestCase
{

    public function test_visit()
    {
        $user = factory(User::class)->create([
            'invite_balance' => 100,
        ]);
        factory(UserInviteBalanceRecord::class, 20)->create(['user_id' => $user->id]);
        $this->actingAs($user)
            ->visit(route('member.invite_balance_records'))
            ->seeStatusCode(200)
            ->seeElement('.pagination');
    }

}