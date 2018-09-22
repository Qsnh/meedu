<?php

namespace Tests\Feature\Page;

use App\Models\Role;
use App\Models\UserJoinRoleRecord;
use App\User;
use Carbon\Carbon;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class MemberJoinRoleTest extends TestCase
{

    public function test_member_join_role()
    {
        $user = factory(User::class)->create();
        $this->actingAs($user)
            ->visit(route('member.join_role_records'))
            ->see('暂无数据');
    }

    public function test_member_join_role_see_some_records()
    {
        $role = factory(Role::class)->create();
        $user = factory(User::class)->create();
        $record = $user->joinRoles()->save(new UserJoinRoleRecord([
            'role_id' => $role->id,
            'charge' => mt_rand(1, 100),
            'start_date' => Carbon::now(),
            'expired_date' => Carbon::now()->addDays(30),
        ]));
        $this->actingAs($user)
            ->visit(route('member.join_role_records'))
            ->see($record->charge)
            ->see($record->started_date)
            ->see($record->exprired_date);
    }

}
