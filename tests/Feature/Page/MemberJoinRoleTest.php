<?php

namespace Tests\Feature\Page;

use App\Services\Member\Models\Role;
use App\Services\Member\Models\User;
use App\Services\Member\Models\UserJoinRoleRecord;
use Carbon\Carbon;
use Tests\TestCase;

class MemberJoinRoleTest extends TestCase
{

    public function test_member_join_role()
    {
        $user = factory(User::class)->create();
        $this->actingAs($user)
            ->visit(route('member.join_role_records'))
            ->assertResponseStatus(200);
    }

    public function test_member_join_role_see_some_records()
    {
        $role = factory(Role::class)->create();
        $user = factory(User::class)->create();
        $record = UserJoinRoleRecord::create([
            'user_id' => $user->id,
            'role_id' => $role->id,
            'charge' => random_int(1, 100),
            'start_date' => Carbon::now(),
            'expired_date' => Carbon::now()->addDays(30),
        ]);
        $this->actingAs($user)
            ->visit(route('member.join_role_records'))
            ->see($record->charge)
            ->see($record->started_date)
            ->see($record->exprired_date);
    }

}
