<?php

/*
 * This file is part of the Qsnh/meedu.
 *
 * (c) 杭州白书科技有限公司
 */

namespace Tests\Unit\Bus;

use Tests\TestCase;
use App\Models\Administrator;
use App\Bus\AdminPermissionBus;
use App\Models\AdministratorRole;
use Illuminate\Support\Facades\Hash;
use App\Models\AdministratorPermission;

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

    public function test_inWhitelist()
    {
        $this->assertTrue($this->adminPermissionBus->inWhitelist('user'));
        $this->assertTrue($this->adminPermissionBus->inWhitelist('login'));
        $this->assertTrue($this->adminPermissionBus->inWhitelist('dashboard'));
        $this->assertTrue($this->adminPermissionBus->inWhitelist('dashboard/system/info'));
        $this->assertTrue($this->adminPermissionBus->inWhitelist('dashboard/check'));
        $this->assertTrue($this->adminPermissionBus->inWhitelist('role/all'));
        $this->assertTrue($this->adminPermissionBus->inWhitelist('administrator_permission'));
        $this->assertTrue($this->adminPermissionBus->inWhitelist('course/all'));
        $this->assertTrue($this->adminPermissionBus->inWhitelist('upload/image/tinymce'));
        $this->assertTrue($this->adminPermissionBus->inWhitelist('upload/image/download'));
        $this->assertTrue($this->adminPermissionBus->inWhitelist('administrator/password'));

        $this->assertFalse($this->adminPermissionBus->inWhitelist('unknown'));
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

    public function test_hasPermission_with_empty_role()
    {
        $this->artisan('install', ['action' => 'role']);

        $admin = Administrator::create([
            'name' => 'test',
            'email' => 'meedu@email.com',
            'password' => Hash::make('testtest'),
        ]);
        $this->assertFalse($this->adminPermissionBus->hasPermission($admin['id'], 'course', 'GET'));
    }

    public function test_hasPermission_with_role_and_empty_permission()
    {
        $this->artisan('install', ['action' => 'role']);

        $admin = Administrator::create([
            'name' => 'test',
            'email' => 'meedu@email.com',
            'password' => Hash::make('testtest'),
        ]);
        $role = AdministratorRole::create([
            'slug' => 'test',
            'display_name' => 'test',
            'description' => 'test',
        ]);

        $admin->roles()->attach([$role['id']]);

        $this->assertFalse($this->adminPermissionBus->hasPermission($admin['id'], 'course', 'GET'));
    }

    public function test_hasPermission_with_some_permission()
    {
        $this->artisan('install', ['action' => 'role']);

        $admin = Administrator::create([
            'name' => 'test',
            'email' => 'meedu@email.com',
            'password' => Hash::make('testtest'),
        ]);
        $role = AdministratorRole::create([
            'slug' => 'test',
            'display_name' => 'test',
            'description' => 'test',
        ]);

        $permissionIds = AdministratorPermission::query()
            ->select(['id'])
            ->whereIn('slug', [
                'courseCategory.update',
                'courseCategory.store',
            ])
            ->get()
            ->pluck('id')
            ->toArray();
        $role->permissions()->attach($permissionIds);

        $admin->roles()->attach([$role['id']]);

        // 不存在
        $this->assertFalse($this->adminPermissionBus->hasPermission($admin['id'], 'course', 'GET'));

        // 存在
        $this->assertTrue($this->adminPermissionBus->hasPermission($admin['id'], 'courseCategory', 'POST'));
        $this->assertTrue($this->adminPermissionBus->hasPermission($admin['id'], 'courseCategory/create', 'GET'));
        $this->assertTrue($this->adminPermissionBus->hasPermission($admin['id'], 'courseCategory/123', 'PUT'));
        $this->assertTrue($this->adminPermissionBus->hasPermission($admin['id'], 'courseCategory/123', 'GET'));

        // 规则不满足
        $this->assertFalse($this->adminPermissionBus->hasPermission($admin['id'], 'courseCategory/abc', 'GET'));
        $this->assertFalse($this->adminPermissionBus->hasPermission($admin['id'], 'courseCategory/abc', 'PUT'));
    }
}
