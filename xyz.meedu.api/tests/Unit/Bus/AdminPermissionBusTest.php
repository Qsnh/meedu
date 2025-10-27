<?php

/*
 * This file is part of the MeEdu.
 *
 * (c) 杭州白书科技有限公司
 */

namespace Tests\Unit\Bus;

use Tests\TestCase;
use App\Models\Administrator;
use App\Bus\AdminPermissionBus;
use App\Models\AdministratorRole;
use Illuminate\Support\Facades\Hash;

class AdminPermissionBusTest extends TestCase
{

    /**
     * @var AdminPermissionBus
     */
    protected $adminPermissionBus;

    public function setUp(): void
    {
        parent::setUp();
        $this->adminPermissionBus = $this->app->make(AdminPermissionBus::class);
    }

    public function test_isSuperAdmin()
    {
        $simpleRole = AdministratorRole::create([
            'slug' => 'test',
            'display_name' => 'test',
            'description' => 'test',
        ]);
        $admin = Administrator::create([
            'name' => 'test',
            'email' => 'meedu@email.com',
            'password' => Hash::make('testtest'),
        ]);

        // 开始关联一个simpleRole
        $admin->roles()->attach([$simpleRole['id']]);
        $this->assertFalse($this->adminPermissionBus->isSuperAdmin($admin['id']));

        // 关联superRole
        $superRole = AdministratorRole::create([
            'slug' => config('meedu.administrator.super_slug'),
            'display_name' => 'super',
            'description' => 'super',
        ]);
        $admin->roles()->attach([$superRole['id']]);
        $this->assertTrue($this->adminPermissionBus->isSuperAdmin($admin['id']));

        // 移除simpleRole,superRole依旧存在
        $admin->roles()->detach([$simpleRole['id']]);
        $this->assertTrue($this->adminPermissionBus->isSuperAdmin($admin['id']));

        // 移除superRole
        $admin->roles()->detach([$superRole['id']]);
        $this->assertFalse($this->adminPermissionBus->isSuperAdmin($admin['id']));
    }
}
