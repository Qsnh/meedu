<?php

/*
 * This file is part of the Qsnh/meedu.
 *
 * (c) 杭州白书科技有限公司
 */

namespace Tests\Feature\Page;

use Tests\TestCase;
use App\Services\Member\Models\User;
use App\Services\Member\Models\UserCreditRecord;

class MemberCredit1RecordsTest extends TestCase
{
    public function test_member_join_role()
    {
        $user = User::factory()->create();
        $this->actingAs($user)
            ->visit(route('member.credit1_records'))
            ->assertResponseStatus(200);
    }

    public function test_member_join_role_see_some_records()
    {
        $user = User::factory()->create();

        UserCreditRecord::factory()->create([
            'user_id' => $user->id,
            'sum' => 1011,
            'remark' => 'meedutest',
        ]);
        UserCreditRecord::factory()->create([
            'user_id' => $user->id,
            'sum' => 2019,
            'remark' => 'testmeedu',
        ]);

        $this->actingAs($user)
            ->visit(route('member.credit1_records'))
            ->assertResponseStatus(200)
            ->see(1011)
            ->see('meedutest')
            ->see(2019)
            ->see('testmeedu');
    }

    public function test_member_join_role_paginate()
    {
        $user = User::factory()->create();

        UserCreditRecord::factory()->create([
            'user_id' => $user->id,
            'sum' => -892,
            'remark' => 'testpaginate2',
        ]);
        UserCreditRecord::factory()->create([
            'user_id' => $user->id,
            'sum' => 1000989,
            'remark' => 'testpaginate1',
        ]);
        UserCreditRecord::factory()->count(19)->create([
            'user_id' => $user->id,
        ]);

        $this->actingAs($user)
            ->visit(route('member.credit1_records'))
            ->assertResponseStatus(200)
            ->dontSee('testpaginate1')
            ->dontSee('testpaginate2');

        $this->actingAs($user)
            ->visit(route('member.credit1_records') . '?page=2')
            ->assertResponseStatus(200)
            ->see('testpaginate1')
            ->dontSee('testpaginate2');

        $this->actingAs($user)
            ->visit(route('member.credit1_records') . '?page=3')
            ->assertResponseStatus(200)
            ->dontSee('testpaginate1')
            ->see('testpaginate2');
    }
}
