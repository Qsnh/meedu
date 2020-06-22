<?php

/*
 * This file is part of the Qsnh/meedu.
 *
 * (c) XiaoTeng <616896861@qq.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace Tests\Feature\Page;

use Tests\TestCase;
use App\Services\Member\Models\User;
use App\Services\Member\Models\UserCreditRecord;

class MemberCredit1RecordsTest extends TestCase
{
    public function test_member_join_role()
    {
        $user = factory(User::class)->create();
        $this->actingAs($user)
            ->visit(route('member.credit1_records'))
            ->assertResponseStatus(200);
    }

    public function test_member_join_role_see_some_records()
    {
        $user = factory(User::class)->create();

        factory(UserCreditRecord::class)->create([
            'user_id' => $user->id,
            'sum' => 1011,
            'remark' => 'meedutest',
        ]);
        factory(UserCreditRecord::class)->create([
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
        $user = factory(User::class)->create();

        factory(UserCreditRecord::class)->create([
            'user_id' => $user->id,
            'sum' => -892,
            'remark' => 'testpaginate2',
        ]);
        factory(UserCreditRecord::class)->create([
            'user_id' => $user->id,
            'sum' => 1000989,
            'remark' => 'testpaginate1',
        ]);
        factory(UserCreditRecord::class, 19)->create([
            'user_id' => $user->id,
        ]);

        $this->actingAs($user)
            ->visit(route('member.credit1_records'))
            ->assertResponseStatus(200)
            ->dontSee('testpaginate1')
            ->dontSee('testpaginate2');

        $this->actingAs($user)
            ->visit(route('member.credit1_records').'?page=2')
            ->assertResponseStatus(200)
            ->see('testpaginate1')
            ->dontSee('testpaginate2');

        $this->actingAs($user)
            ->visit(route('member.credit1_records').'?page=3')
            ->assertResponseStatus(200)
            ->dontSee('testpaginate1')
            ->see('testpaginate2');
    }
}
