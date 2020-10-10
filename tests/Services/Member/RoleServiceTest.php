<?php

/*
 * This file is part of the Qsnh/meedu.
 *
 * (c) XiaoTeng <616896861@qq.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace Tests\Services\Member;

use Carbon\Carbon;
use Tests\TestCase;
use App\Services\Member\Models\Role;
use App\Services\Member\Models\User;
use Illuminate\Support\Facades\Auth;
use App\Services\Member\Services\RoleService;
use App\Services\Member\Models\UserJoinRoleRecord;
use App\Services\Member\Interfaces\RoleServiceInterface;

class RoleServiceTest extends TestCase
{

    /**
     * @var RoleService
     */
    protected $service;

    public function setUp(): void
    {
        parent::setUp();
        $this->service = $this->app->make(RoleServiceInterface::class);
    }

    public function test_all()
    {
        factory(Role::class, 5)->create();
        $all = $this->service->all();
        $this->assertNotEmpty($all);
        $this->assertEquals(5, count($all));
    }

    public function test_find()
    {
        $role = factory(Role::class)->create();
        $r = $this->service->find($role->id);
        $this->assertEquals($role->name, $r['name']);
    }

    public function test_userRolePaginate()
    {
        $user = factory(User::class)->create();
        Auth::login($user);

        factory(UserJoinRoleRecord::class, 6)->create([
            'user_id' => $user->id,
        ]);
        $list = $this->service->userRolePaginate(2, 3);
        $this->assertEquals(6, $list['total']);
        $this->assertEquals(3, count($list['list']));
    }

    public function test_userJoinRole()
    {
        $user = factory(User::class)->create();
        Auth::login($user);

        $role = factory(Role::class)->create(['expire_days' => 1]);

        $this->service->userJoinRole($user->toArray(), $role->toArray(), 1);

        $record = UserJoinRoleRecord::whereUserId($user->id)->whereRoleId($role->id)->whereCharge(1)->first();
        $this->assertNotNull($record);
        $this->assertEquals(3600 * 24, strtotime($record->expired_at) - strtotime($record->started_at));

        $user->refresh();
        $this->assertEquals($role->id, $user->role_id);
        $this->assertTrue(abs(Carbon::now()->addDays($role->expire_days)->timestamp - strtotime($user->role_expired_at)) < 5);
    }

    public function test_userContinueRole_expired()
    {
        $role = factory(Role::class)->create(['expire_days' => 2]);
        $user = factory(User::class)->create([
            'role_id' => $role->id,
            'role_expired_at' => '2018/08/08',
        ]);

        $this->service->userContinueRole($user->toArray(), $role->toArray(), 1);

        $user->refresh();
        $this->assertTrue(abs(Carbon::parse($user->role_expired_at)->timestamp - Carbon::now()->addDays(2)->timestamp) < 2);
    }

    public function test_userContinueRole()
    {
        $role = factory(Role::class)->create(['expire_days' => 2]);

        $now = Carbon::now()->addDays(1);
        $user = factory(User::class)->create([
            'role_id' => $role->id,
            'role_expired_at' => $now,
        ]);
        Auth::login($user);

        $this->service->userContinueRole($user->toArray(), $role->toArray(), 1);

        $record = UserJoinRoleRecord::whereUserId($user->id)->whereRoleId($role->id)->whereCharge(1)->orderByDesc('id')->first();
        $this->assertNotNull($record);
        $this->assertEquals(3600 * 24 * 2, strtotime($record->expired_at) - strtotime($record->started_at));

        $user->refresh();
        $this->assertTrue(abs($now->addDays($role->expire_days)->timestamp - strtotime($user->role_expired_at)) < 5);
    }
}
