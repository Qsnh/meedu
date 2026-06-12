<?php

/*
 * This file is part of the MeEdu.
 *
 * (c) 杭州白书科技有限公司
 */

namespace Tests\Api\Backend;

use App\Models\Administrator;
use App\Models\AdministratorRole;
use Illuminate\Support\Facades\DB;
use App\Constant\BackendPermission;
use App\Models\AdministratorPermission;
use App\Services\Other\Models\ViewBlock;
use App\Services\Other\Models\DecorationPage;

class ViewBlockTest extends Base
{
    protected Administrator $regularAdmin;
    protected AdministratorRole $regularRole;
    protected Administrator $superAdmin;
    protected AdministratorRole $superRole;
    protected DecorationPage $page;
    protected AdministratorPermission $pageBlocksPermission;

    public function setUp(): void
    {
        parent::setUp();

        // 普通管理员:有装修页面管理权限,但没有代码块编辑权限
        $this->regularAdmin = Administrator::factory()->create();
        // AdministratorRoleFactory 默认 slug 为 super_slug,这里覆盖为非超管 slug
        $this->regularRole = AdministratorRole::factory()->create([
            'slug' => 'regular-decoration-' . uniqid(),
        ]);
        DB::table('administrator_role_relation')->insert([
            'administrator_id' => $this->regularAdmin->id,
            'role_id' => $this->regularRole->id,
        ]);

        // 为普通角色挂上路由级别需要的 decorationPage.blocks 权限,
        // 让请求能通过 mbp 中间件,从而触发到控制器内部的代码块权限校验
        $this->pageBlocksPermission = AdministratorPermission::query()->create([
            'group_name' => '装修',
            'display_name' => '装修-页面-blocks',
            'slug' => BackendPermission::DECORATION_PAGE_BLOCKS,
            'method' => '',
            'route' => '',
            'url' => '',
            'description' => '',
            'sort' => 2010,
        ]);
        DB::table('administrator_role_permission_relation')->insert([
            'role_id' => $this->regularRole->id,
            'permission_id' => $this->pageBlocksPermission->id,
        ]);

        // 超管:slug 与 config('meedu.administrator.super_slug') 一致
        $superSlug = config('meedu.administrator.super_slug');
        $this->superAdmin = Administrator::factory()->create();
        $this->superRole = AdministratorRole::factory()->create(['slug' => $superSlug]);
        DB::table('administrator_role_relation')->insert([
            'administrator_id' => $this->superAdmin->id,
            'role_id' => $this->superRole->id,
        ]);

        // 装修页面
        $this->page = DecorationPage::query()->create([
            'name' => 'home',
            'page_key' => 'pc-index-' . uniqid(),
            'platform' => 'pc',
            'page' => 'index',
            'is_default' => 0,
        ]);
    }

    public function tearDown(): void
    {
        $this->regularAdmin->delete();
        $this->superAdmin->delete();
        $this->page->delete();
        parent::tearDown();
    }

    public function test_regular_admin_cannot_create_code_block()
    {
        $response = $this->user($this->regularAdmin)->post(self::API_V1_PREFIX . '/viewBlock/create', [
            'page_id' => $this->page->id,
            'sign' => 'code',
            'sort' => 0,
            'config' => ['html' => '<script>alert(1)</script>'],
        ]);
        $this->assertResponseError($response);

        $this->assertSame(0, ViewBlock::query()->where('decoration_page_id', $this->page->id)->count());
    }

    public function test_regular_admin_can_create_non_code_block()
    {
        $response = $this->user($this->regularAdmin)->post(self::API_V1_PREFIX . '/viewBlock/create', [
            'page_id' => $this->page->id,
            'sign' => 'pc-slider',
            'sort' => 0,
            'config' => [],
        ]);
        $this->assertResponseSuccess($response);
    }

    public function test_regular_admin_with_permission_can_create_code_block()
    {
        $perm = AdministratorPermission::query()->create([
            'group_name' => '装修',
            'display_name' => '装修-代码块-编辑',
            'slug' => BackendPermission::DECORATION_CODE_BLOCK_EDIT,
            'method' => '',
            'route' => '',
            'url' => '',
            'description' => '',
            'sort' => 2015,
        ]);
        DB::table('administrator_role_permission_relation')->insert([
            'role_id' => $this->regularRole->id,
            'permission_id' => $perm->id,
        ]);

        $response = $this->user($this->regularAdmin)->post(self::API_V1_PREFIX . '/viewBlock/create', [
            'page_id' => $this->page->id,
            'sign' => 'code',
            'sort' => 0,
            'config' => ['html' => 'whatever'],
        ]);
        $this->assertResponseSuccess($response);
    }

    public function test_super_admin_can_create_code_block()
    {
        $response = $this->user($this->superAdmin)->post(self::API_V1_PREFIX . '/viewBlock/create', [
            'page_id' => $this->page->id,
            'sign' => 'code',
            'sort' => 0,
            'config' => ['html' => 'whatever'],
        ]);
        $this->assertResponseSuccess($response);
    }

    public function test_regular_admin_cannot_update_code_block()
    {
        $block = ViewBlock::query()->create([
            'platform' => '',
            'page' => '',
            'decoration_page_id' => $this->page->id,
            'sign' => 'code',
            'config' => json_encode(['html' => 'old']),
            'sort' => 0,
        ]);

        $response = $this->user($this->regularAdmin)->put(self::API_V1_PREFIX . '/viewBlock/' . $block->id, [
            'sort' => 0,
            'config' => ['html' => 'new'],
        ]);
        $this->assertResponseError($response);
    }

    public function test_regular_admin_cannot_destroy_code_block()
    {
        $block = ViewBlock::query()->create([
            'platform' => '',
            'page' => '',
            'decoration_page_id' => $this->page->id,
            'sign' => 'code',
            'config' => json_encode(['html' => 'x']),
            'sort' => 0,
        ]);

        $response = $this->user($this->regularAdmin)->delete(self::API_V1_PREFIX . '/viewBlock/' . $block->id);
        $this->assertResponseError($response);

        $this->assertNotNull(ViewBlock::query()->find($block->id));
    }
}
