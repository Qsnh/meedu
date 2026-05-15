# 用户协议与装修代码块 XSS 修复 — 实施计划

> **For agentic workers:** REQUIRED SUB-SKILL: Use superpowers:subagent-driven-development (recommended) or superpowers:executing-plans to implement this plan task-by-task. Steps use checkbox (`- [ ]`) syntax for tracking.

**Goal:** 消除用户协议(服务/隐私/付费内容)与装修代码块两类 XSS 攻击面 —— 协议侧用 HTMLPurifier 白名单过滤、代码块侧用新增 super-admin-only 权限收紧。

**Architecture:**
- **协议侧**:在 `AgreementRequest::filldata()` 用 `Purifier::clean()` 净化保存内容(trust-on-write),配套 Artisan 命令 `agreement:sanitize-history` 处理存量数据。Blade 模板维持 `{!! !!}`。
- **代码块侧**:新增权限 `decorationPage.codeBlockEdit`,在 `ViewBlockController` 的 `store / update / destroy` 内按 `sign === 'code'` 触发权限校验(超管 bypass);admin 前端隐藏代码块入口和编辑按钮。
- **范围**:`xyz.meedu.api` 后端 + `xyz.meedu.admin` 前端;C 端落地页(`xyz.meedu.pc` / `xyz.meedu.h5`)不动。

**Tech Stack:** Laravel 9 / PHP 8 / PHPUnit / mews/purifier(已在 composer.json)/ React + TypeScript(admin)。

**设计文档:** `docs/superpowers/specs/2026-05-14-xss-fix-agreement-decoration-design.md`

---

## File Inventory

### 新建文件
- `xyz.meedu.api/app/Console/Commands/AgreementSanitizeCommand.php` — Artisan 命令,净化存量协议
- `xyz.meedu.api/tests/Api/Backend/AgreementSanitizeTest.php` — 协议保存净化的功能测试
- `xyz.meedu.api/tests/Commands/AgreementSanitizeCommandTest.php` — Artisan 命令的测试
- `xyz.meedu.api/tests/Api/Backend/ViewBlockTest.php` — 装修代码块权限校验的测试

### 修改文件(后端)
- `xyz.meedu.api/app/Http/Requests/Backend/AgreementRequest.php` — `filldata()` 调用 Purifier 净化 `content`
- `xyz.meedu.api/app/Constant/BackendPermission.php` — 新增 `DECORATION_CODE_BLOCK_EDIT` 常量
- `xyz.meedu.api/database/seeders/AdministratorPermissionSeeder.php` — 注册新权限,sort=2015
- `xyz.meedu.api/app/Http/Controllers/Backend/Api/V1/ViewBlockController.php` — `store / update / destroy` 新增 code block 权限校验

### 修改文件(前端 admin)
- `xyz.meedu.admin/src/pages/decoration/pc.tsx` — 隐藏"代码块"拖拽入口、隐藏 code block 的编辑/删除/复制按钮
- `xyz.meedu.admin/src/pages/decoration/h5.tsx` — 同上(H5 端)
- `xyz.meedu.admin/src/pages/decoration/components/pc/config/index.tsx` — 无权限时不渲染 `CodeSet`

### 修改文件(其他)
- `CHANGELOG.md` — 追加安全修复条目

---

## 运行时约定

- **PHP 测试**:`cd xyz.meedu.api && ./vendor/bin/phpunit tests/Api/Backend/<file>.php --filter <method>`
- **PHP lint(可选)**:`cd xyz.meedu.api && composer dump-autoload`(确保新文件被自动加载)
- **前端 lint**:`cd xyz.meedu.admin && npm run build` 验证 TS 通过
- **提交单元**:每个 Task 完成后立刻提交,提交信息按项目风格(中文 `修复:[模块] ...` / `增加:[模块] ...`)

---

## Task 1:协议保存时净化 — 编写失败测试

**Files:**
- Create: `xyz.meedu.api/tests/Api/Backend/AgreementSanitizeTest.php`

- [ ] **Step 1.1: 编写测试,验证含 `<script>` 的协议保存后被剥除**

写入 `xyz.meedu.api/tests/Api/Backend/AgreementSanitizeTest.php`:

```php
<?php

/*
 * This file is part of the MeEdu.
 *
 * (c) 杭州白书科技有限公司
 */

namespace Tests\Api\Backend;

use App\Constant\AgreementConstant;
use App\Http\Requests\Backend\AgreementRequest;
use Tests\TestCase;

class AgreementSanitizeTest extends TestCase
{
    public function test_filldata_strips_script_tag()
    {
        $request = new AgreementRequest();
        $request->merge([
            'type' => array_key_first(AgreementConstant::TYPES),
            'title' => '服务协议',
            'content' => '<p>正文</p><script>alert(1)</script>',
            'version' => 'v1',
            'is_active' => 0,
        ]);

        $data = $request->filldata();

        $this->assertStringNotContainsString('<script', $data['content']);
        $this->assertStringNotContainsString('alert(1)', $data['content']);
        $this->assertStringContainsString('<p>正文</p>', $data['content']);
    }

    public function test_filldata_strips_javascript_href()
    {
        $request = new AgreementRequest();
        $request->merge([
            'type' => array_key_first(AgreementConstant::TYPES),
            'title' => '服务协议',
            'content' => '<a href="javascript:alert(1)">点击</a>',
            'version' => 'v1',
            'is_active' => 0,
        ]);

        $data = $request->filldata();

        $this->assertStringNotContainsString('javascript:', $data['content']);
    }

    public function test_filldata_preserves_safe_rich_text()
    {
        $request = new AgreementRequest();
        $request->merge([
            'type' => array_key_first(AgreementConstant::TYPES),
            'title' => '服务协议',
            'content' => '<p><strong>加粗</strong><em>斜体</em></p><ul><li>条目</li></ul>',
            'version' => 'v1',
            'is_active' => 0,
        ]);

        $data = $request->filldata();

        $this->assertStringContainsString('<strong>加粗</strong>', $data['content']);
        $this->assertStringContainsString('<em>斜体</em>', $data['content']);
        $this->assertStringContainsString('<li>条目</li>', $data['content']);
    }
}
```

- [ ] **Step 1.2: 运行测试,确认失败**

Run:
```bash
cd xyz.meedu.api && ./vendor/bin/phpunit tests/Api/Backend/AgreementSanitizeTest.php --filter test_filldata_strips_script_tag
```
Expected: FAIL — 因为当前 `filldata()` 不做净化,`<script>` 仍在 `$data['content']` 中。

---

## Task 2:协议保存时净化 — 实现

**Files:**
- Modify: `xyz.meedu.api/app/Http/Requests/Backend/AgreementRequest.php`

- [ ] **Step 2.1: 在 `AgreementRequest::filldata()` 中对 `content` 调用 Purifier**

把 `xyz.meedu.api/app/Http/Requests/Backend/AgreementRequest.php` 顶部 `use` 区(在 `use Carbon\Carbon;` 一行下方)加入:

```php
use Mews\Purifier\Facades\Purifier;
```

并把 `filldata()` 方法中第 77 行(原文为 `'content' => $this->input('content'),`)改为:

```php
            'content' => Purifier::clean((string)$this->input('content'), 'default'),
```

完整的 `filldata()` 实现应为:

```php
    public function filldata()
    {
        $data = [
            'type' => $this->input('type'),
            'title' => $this->input('title'),
            'content' => Purifier::clean((string)$this->input('content'), 'default'),
            'version' => $this->input('version'),
            'is_active' => (int)$this->input('is_active'),
        ];

        // 如果选择生效，设置生效时间
        if ($data['is_active']) {
            $data['effective_at'] = $this->input('effective_at') ? Carbon::parse($this->input('effective_at')) : null;
        } else {
            // 如果取消生效，清空生效时间
            $data['effective_at'] = null;
        }

        return $data;
    }
```

- [ ] **Step 2.2: 运行三个测试,确认全部通过**

Run:
```bash
cd xyz.meedu.api && ./vendor/bin/phpunit tests/Api/Backend/AgreementSanitizeTest.php
```
Expected: 3 tests passing, 0 failures.

- [ ] **Step 2.3: 提交**

```bash
cd /Users/tengyongzhi/work/bot-workspaces/meedu-workspaces/meedu2
git add xyz.meedu.api/app/Http/Requests/Backend/AgreementRequest.php xyz.meedu.api/tests/Api/Backend/AgreementSanitizeTest.php
git commit -m "修复:[API]用户协议保存时未做 XSS 净化"
```

---

## Task 3:存量协议数据净化命令 — 编写失败测试

**Files:**
- Create: `xyz.meedu.api/tests/Commands/AgreementSanitizeCommandTest.php`

- [ ] **Step 3.1: 编写测试**

写入 `xyz.meedu.api/tests/Commands/AgreementSanitizeCommandTest.php`:

```php
<?php

/*
 * This file is part of the MeEdu.
 *
 * (c) 杭州白书科技有限公司
 */

namespace Tests\Commands;

use App\Constant\AgreementConstant;
use App\Meedu\Cache\Impl\ActiveAgreementCache;
use App\Meedu\ServiceV2\Models\Agreement;
use Illuminate\Support\Facades\Cache;
use Tests\TestCase;

class AgreementSanitizeCommandTest extends TestCase
{
    public function test_command_strips_script_from_existing_rows()
    {
        $type = array_key_first(AgreementConstant::TYPES);

        $agreement = Agreement::query()->create([
            'type' => $type,
            'title' => '历史协议',
            'content' => '<p>合法</p><script>alert(1)</script>',
            'version' => 'v0',
            'is_active' => 0,
        ]);

        $this->artisan('agreement:sanitize-history')->assertExitCode(0);

        $agreement->refresh();
        $this->assertStringNotContainsString('<script', $agreement->content);
        $this->assertStringNotContainsString('alert(1)', $agreement->content);
    }

    public function test_dry_run_does_not_modify_data()
    {
        $type = array_key_first(AgreementConstant::TYPES);
        $original = '<p>正文</p><script>alert(1)</script>';

        $agreement = Agreement::query()->create([
            'type' => $type,
            'title' => '历史协议',
            'content' => $original,
            'version' => 'v0',
            'is_active' => 0,
        ]);

        $this->artisan('agreement:sanitize-history', ['--dry-run' => true])->assertExitCode(0);

        $agreement->refresh();
        $this->assertSame($original, $agreement->content);
    }

    public function test_command_clears_active_agreement_cache()
    {
        $type = array_key_first(AgreementConstant::TYPES);

        Agreement::query()->create([
            'type' => $type,
            'title' => '历史协议',
            'content' => '<script>alert(1)</script>',
            'version' => 'v1',
            'is_active' => 1,
            'effective_at' => now()->subDay(),
        ]);

        Cache::put(sprintf(ActiveAgreementCache::CACHE_KEY, $type), ['stale' => true], 60);

        $this->artisan('agreement:sanitize-history')->assertExitCode(0);

        $this->assertFalse(Cache::has(sprintf(ActiveAgreementCache::CACHE_KEY, $type)));
    }
}
```

- [ ] **Step 3.2: 运行测试,确认失败**

Run:
```bash
cd xyz.meedu.api && ./vendor/bin/phpunit tests/Commands/AgreementSanitizeCommandTest.php
```
Expected: FAIL — 命令未实现。

---

## Task 4:存量协议数据净化命令 — 实现

**Files:**
- Create: `xyz.meedu.api/app/Console/Commands/AgreementSanitizeCommand.php`

- [ ] **Step 4.1: 编写命令**

写入 `xyz.meedu.api/app/Console/Commands/AgreementSanitizeCommand.php`:

```php
<?php

/*
 * This file is part of the MeEdu.
 *
 * (c) 杭州白书科技有限公司
 */

namespace App\Console\Commands;

use App\Meedu\Cache\Impl\ActiveAgreementCache;
use App\Meedu\ServiceV2\Models\Agreement;
use Illuminate\Console\Command;
use Mews\Purifier\Facades\Purifier;

class AgreementSanitizeCommand extends Command
{
    protected $signature = 'agreement:sanitize-history {--dry-run : 仅打印差异,不写库}';

    protected $description = '使用 HTMLPurifier 净化 agreements 表中的存量内容,并清理生效协议缓存';

    public function handle(): int
    {
        $dryRun = (bool)$this->option('dry-run');

        $total = 0;
        $changed = 0;
        $changedTypes = [];

        Agreement::query()->orderBy('id')->chunkById(100, function ($rows) use (&$total, &$changed, &$changedTypes, $dryRun) {
            foreach ($rows as $agreement) {
                $total++;
                $clean = Purifier::clean((string)$agreement->content, 'default');
                if ($clean === $agreement->content) {
                    continue;
                }

                $changed++;
                $changedTypes[$agreement->type] = true;

                $this->line(sprintf('agreement id=%d type=%s 将被净化', $agreement->id, $agreement->type));

                if (!$dryRun) {
                    $agreement->content = $clean;
                    $agreement->save();
                }
            }
        });

        $this->info(sprintf('扫描 %d 条,需净化 %d 条%s', $total, $changed, $dryRun ? ' (dry-run,未写库)' : ''));

        if (!$dryRun && $changed > 0) {
            foreach (array_keys($changedTypes) as $type) {
                ActiveAgreementCache::forget($type);
            }
            $this->info('已清理涉及 type 的生效协议缓存');
        }

        return self::SUCCESS;
    }
}
```

- [ ] **Step 4.2: 运行测试,确认全部通过**

Run:
```bash
cd xyz.meedu.api && ./vendor/bin/phpunit tests/Commands/AgreementSanitizeCommandTest.php
```
Expected: 3 tests passing.

注:Laravel 默认会自动注册 `app/Console/Commands` 下的命令。如果项目里有显式注册位置(检查 `app/Console/Kernel.php` 的 `$commands` 属性),按既有风格补一行。

- [ ] **Step 4.3: 提交**

```bash
git add xyz.meedu.api/app/Console/Commands/AgreementSanitizeCommand.php xyz.meedu.api/tests/Commands/AgreementSanitizeCommandTest.php
git commit -m "增加:[API]Artisan 命令 agreement:sanitize-history 净化协议存量数据"
```

---

## Task 5:新增装修代码块权限常量

**Files:**
- Modify: `xyz.meedu.api/app/Constant/BackendPermission.php`

- [ ] **Step 5.1: 添加常量**

在 `xyz.meedu.api/app/Constant/BackendPermission.php` 第 30 行 `public const DECORATION_PAGE_BLOCKS = 'decorationPage.blocks';` 之后新增一行:

```php
    public const DECORATION_CODE_BLOCK_EDIT = 'decorationPage.codeBlockEdit';
```

完整局部上下文应为:

```php
    public const DECORATION_PAGE_BLOCKS = 'decorationPage.blocks';
    public const DECORATION_CODE_BLOCK_EDIT = 'decorationPage.codeBlockEdit';

    // 友情链接
    public const LINK = 'link';
```

- [ ] **Step 5.2: 提交**

```bash
git add xyz.meedu.api/app/Constant/BackendPermission.php
git commit -m "增加:[API]新增 decorationPage.codeBlockEdit 权限常量"
```

---

## Task 6:Seeder 注册新权限

**Files:**
- Modify: `xyz.meedu.api/database/seeders/AdministratorPermissionSeeder.php`

- [ ] **Step 6.1: 在装修分组末尾追加权限项**

定位到 `AdministratorPermissionSeeder.php` 第 121 行 `'slug' => BackendPermission::NAV_DESTROY,`(sort 2014)所在条目的结束括号(第 122 行 `],`)。在第 122 行 `],` 之后、第 123 行 `],` 之前插入新条目:

```php
                    [
                        'display_name' => '装修-代码块-编辑',
                        'slug' => BackendPermission::DECORATION_CODE_BLOCK_EDIT,
                        'sort' => 2015,
                    ],
```

插入后该装修分组结尾应为:

```php
                    [
                        'display_name' => '装修-PC首页导航-删除',
                        'slug' => BackendPermission::NAV_DESTROY,
                        'sort' => 2014,
                    ],
                    [
                        'display_name' => '装修-代码块-编辑',
                        'slug' => BackendPermission::DECORATION_CODE_BLOCK_EDIT,
                        'sort' => 2015,
                    ],
                ],
            ],
```

Seeder 既有逻辑(744~750 行)是 `where('slug',...)->first()` 后 `fill().save()`,本身幂等。

- [ ] **Step 6.2: 在测试环境跑一次 seeder,验证落库**

Run:
```bash
cd xyz.meedu.api && php artisan db:seed --class=AdministratorPermissionSeeder --no-interaction
```
Expected: 无报错。

可选验证:
```bash
cd xyz.meedu.api && php artisan tinker --execute='echo \App\Models\AdministratorPermission::where("slug","decorationPage.codeBlockEdit")->count();'
```
Expected: 输出 `1`。

- [ ] **Step 6.3: 提交**

```bash
git add xyz.meedu.api/database/seeders/AdministratorPermissionSeeder.php
git commit -m "增加:[API]Seeder 注册 decorationPage.codeBlockEdit 权限"
```

---

## Task 7:装修代码块权限校验 — 编写失败测试

**Files:**
- Create: `xyz.meedu.api/tests/Api/Backend/ViewBlockTest.php`

- [ ] **Step 7.1: 编写测试**

写入 `xyz.meedu.api/tests/Api/Backend/ViewBlockTest.php`:

```php
<?php

/*
 * This file is part of the MeEdu.
 *
 * (c) 杭州白书科技有限公司
 */

namespace Tests\Api\Backend;

use App\Constant\BackendPermission;
use App\Models\Administrator;
use App\Models\AdministratorPermission;
use App\Models\AdministratorRole;
use App\Services\Other\Models\DecorationPage;
use App\Services\Other\Models\ViewBlock;
use Illuminate\Support\Facades\DB;

class ViewBlockTest extends Base
{
    protected Administrator $regularAdmin;
    protected AdministratorRole $regularRole;
    protected Administrator $superAdmin;
    protected AdministratorRole $superRole;
    protected DecorationPage $page;

    public function setUp(): void
    {
        parent::setUp();

        // 普通管理员:有装修页面管理权限,但没有代码块编辑权限
        $this->regularAdmin = Administrator::factory()->create();
        $this->regularRole = AdministratorRole::factory()->create();
        DB::table('administrator_role_relation')->insert([
            'administrator_id' => $this->regularAdmin->id,
            'role_id' => $this->regularRole->id,
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
```

- [ ] **Step 7.2: 运行测试,确认失败**

Run:
```bash
cd xyz.meedu.api && ./vendor/bin/phpunit tests/Api/Backend/ViewBlockTest.php
```
Expected: 多个用例失败 —— 当前 controller 没有任何 sign 维度的权限校验,所有 create / update / destroy 都成功。

---

## Task 8:装修代码块权限校验 — 实现

**Files:**
- Modify: `xyz.meedu.api/app/Http/Controllers/Backend/Api/V1/ViewBlockController.php`

- [ ] **Step 8.1: 引入依赖**

把文件顶部 `use` 区(在 `use App\Services\Other\Models\DecorationPage;` 一行下方)加入:

```php
use App\Bus\AdminPermissionBus;
use App\Constant\BackendPermission;
use Illuminate\Support\Facades\Auth;
```

- [ ] **Step 8.2: 添加共用的权限校验私有方法**

在类内部、`destroy()` 方法下方追加:

```php
    private function ensureCodeBlockPermission(): ?\Illuminate\Http\JsonResponse
    {
        $adminId = (int)Auth::guard('administrator')->id();
        $bus = app(AdminPermissionBus::class);

        if ($bus->isSuperAdmin($adminId)) {
            return null;
        }

        if ($bus->hasPermissionBySlug($adminId, BackendPermission::DECORATION_CODE_BLOCK_EDIT)) {
            return null;
        }

        return $this->error(__('您没有编辑代码块的权限'));
    }
```

- [ ] **Step 8.3: 在 `store` 中插入校验**

把 `store(Request $request)` 方法体开头(第一行 `$pageId = (int)$request->input('page_id');` 之前)改为先取出 `$sign`:

```php
    public function store(Request $request)
    {
        $sign = $request->input('sign');

        if ($sign === 'code') {
            if ($resp = $this->ensureCodeBlockPermission()) {
                return $resp;
            }
        }

        $pageId = (int)$request->input('page_id');
        $config = $request->input('config');
        $sort = (int)$request->input('sort');

        if (!$sign) {
            return $this->error(__('参数错误'));
        }
```

(原方法剩余代码保持不变。注意:原代码也读取 `$sign`,这次提前读取后下游不再重复 `$request->input('sign')`,保持单次读取。)

- [ ] **Step 8.4: 在 `update` 中插入校验**

把 `update(Request $request, $id)` 方法体开头改为:

```php
    public function update(Request $request, $id)
    {
        $block = ViewBlock::query()->where('id', $id)->firstOrFail();

        if ($block->sign === 'code') {
            if ($resp = $this->ensureCodeBlockPermission()) {
                return $resp;
            }
        }

        $config = $request->input('config');
        $sort = $request->input('sort');
        $updateData = ['config' => $config, 'sort' => $sort];
```

后续删除原来的 `$block = ViewBlock::query()->where('id', $id)->firstOrFail();`(已上移),其它保持不变。

- [ ] **Step 8.5: 在 `destroy` 中插入校验**

把 `destroy($id)` 方法体开头改为:

```php
    public function destroy($id)
    {
        $block = ViewBlock::query()->where('id', $id)->first();

        if ($block && $block->sign === 'code') {
            if ($resp = $this->ensureCodeBlockPermission()) {
                return $resp;
            }
        }

        ViewBlock::query()->where('id', $id)->delete();
```

原方法中已有 `$block = ViewBlock::query()->where('id', $id)->first();`,只需在它后面插入 if 块。其余代码不变。

- [ ] **Step 8.6: 运行测试,确认全部通过**

Run:
```bash
cd xyz.meedu.api && ./vendor/bin/phpunit tests/Api/Backend/ViewBlockTest.php
```
Expected: 6 tests passing。

- [ ] **Step 8.7: 跑现有装修相关测试做回归**

Run:
```bash
cd xyz.meedu.api && ./vendor/bin/phpunit tests/Api/Backend/NavTest.php tests/Api/Backend/LinkTest.php
```
Expected: 全绿。

- [ ] **Step 8.8: 提交**

```bash
git add xyz.meedu.api/app/Http/Controllers/Backend/Api/V1/ViewBlockController.php xyz.meedu.api/tests/Api/Backend/ViewBlockTest.php
git commit -m "修复:[API]装修代码块编辑增加 super-admin-only 权限校验"
```

---

## Task 9:Admin 前端 — PC 装修页隐藏代码块拖拽入口与编辑按钮

**Files:**
- Modify: `xyz.meedu.admin/src/pages/decoration/pc.tsx`
- Modify: `xyz.meedu.admin/src/pages/decoration/components/pc/config/index.tsx`

- [ ] **Step 9.1: 在 `pc.tsx` 读取代码块编辑权限**

打开 `xyz.meedu.admin/src/pages/decoration/pc.tsx`,在 `DecorationPCPage` 组件内、`useEffect` 上方新增:

```tsx
  const user = useSelector((state: any) => state.loginUser.value.user);

  const canEditCodeBlock = () => {
    if (!user || !user.permissions) {
      return false;
    }
    return (
      typeof user.permissions["decorationPage.codeBlockEdit"] !== "undefined"
    );
  };
```

(`useSelector` 已经在 import 列表中,直接复用。)

- [ ] **Step 9.2: 隐藏"代码块"拖拽入口**

把 pc.tsx 第 362~375 行的 `<div className={styles["block-item"]} draggable ...>` 包裹整块(代码块)修改为有条件渲染:

```tsx
          {canEditCodeBlock() && (
            <div
              className={styles["block-item"]}
              draggable
              onDragEnd={(e: any) => {
                dragChange(e, "code");
              }}
            >
              <div className={styles["btn"]}>
                <div className={styles["icon"]}>
                  <img draggable={false} src={codeIocn} width={44} height={44} />
                </div>
                <div className={styles["name"]}>代码块</div>
              </div>
            </div>
          )}
```

- [ ] **Step 9.3: 隐藏 code block 的删除/复制按钮**

定位到 `blocks.map(...)` 内 `curBlockIndex === index && (...)` 渲染编辑工具栏的区块(第 408~447 行)。把"删除模块"和"复制模块"两个 Tooltip 包裹一层条件:对于 code block,如果无权限则不渲染。

修改方案:在 `blocks.map((item: any, index: number) => (` 内部、`<div className={curBlockIndex === index ? ...}>` 渲染逻辑前定义局部:

```tsx
              const isCode = item.sign === "code";
              const canTouchThisBlock = !isCode || canEditCodeBlock();
```

然后把删除/复制 Tooltip 改为:

```tsx
                      {canTouchThisBlock && (
                        <Tooltip placement="top" title="删除模块">
                          <div
                            className="btn-item"
                            onClick={() => blockDestroy(index, item)}
                          >
                            <DeleteOutlined />
                          </div>
                        </Tooltip>
                      )}
                      {canTouchThisBlock && (
                        <Tooltip placement="top" title="复制模块">
                          <div
                            className="btn-item"
                            onClick={() => blockCopy(index, item)}
                          >
                            <CopyOutlined />
                          </div>
                        </Tooltip>
                      )}
```

注:`item.sign === "code"` 已经被代码使用,与后端约定一致。

- [ ] **Step 9.4: 在 `PCConfigSetting` 中隐藏 code 块配置面板**

打开 `xyz.meedu.admin/src/pages/decoration/components/pc/config/index.tsx`,把组件改为:

```tsx
import React from "react";
import { useSelector } from "react-redux";
import styles from "./index.module.scss";
import { SliderSet } from "./slider";
import { CodeSet } from "../../h5/config/code";
import { VodV1Set } from "../../h5/config/vod-v1";

interface PropInterface {
  block: any;
  onUpdate: () => void;
}

export const PCConfigSetting: React.FC<PropInterface> = ({
  block,
  onUpdate,
}) => {
  const user = useSelector((state: any) => state.loginUser.value.user);
  const canEditCodeBlock =
    !!user &&
    !!user.permissions &&
    typeof user.permissions["decorationPage.codeBlockEdit"] !== "undefined";

  const update = () => {
    onUpdate();
  };

  return (
    <div className={styles["config-index-box"]}>
      {block.sign === "pc-slider" && (
        <SliderSet block={block} onUpdate={() => update()} />
      )}
      {block.sign === "pc-vod-v1" && (
        <VodV1Set block={block} onUpdate={() => update()} />
      )}
      {block.sign === "code" && canEditCodeBlock && (
        <CodeSet block={block} onUpdate={() => update()} />
      )}
    </div>
  );
};
```

- [ ] **Step 9.5: 编译验证**

Run:
```bash
cd xyz.meedu.admin && npm run build
```
Expected: 编译成功(可能有项目既有的告警,但不应出现新增 TS 错误)。

- [ ] **Step 9.6: 提交**

```bash
git add xyz.meedu.admin/src/pages/decoration/pc.tsx xyz.meedu.admin/src/pages/decoration/components/pc/config/index.tsx
git commit -m "修复:[Admin]PC 装修页代码块入口按权限收紧"
```

---

## Task 10:Admin 前端 — H5 装修页同等收紧

**Files:**
- Modify: `xyz.meedu.admin/src/pages/decoration/h5.tsx`

- [ ] **Step 10.1: 阅读现有结构**

先 `Read` 文件:

Run:
```bash
cd /Users/tengyongzhi/work/bot-workspaces/meedu-workspaces/meedu2 && wc -l xyz.meedu.admin/src/pages/decoration/h5.tsx
```
Expected: 行数确认存在。

- [ ] **Step 10.2: 找出 H5 中代码块对应的 sign 与拖拽入口**

H5 装修的代码块 sign 也是 `code`(与 PC 共用)。打开 `h5.tsx`,定位:
- "拖动添加板块"侧的 code 拖拽 DOM(类似 PC 第 362~375 行的结构)
- `blocks.map` 内对 `item.sign === 'code'` 的删除/复制按钮

按 Task 9 的同款模式改造:
1. 在组件内加 `canEditCodeBlock` 读取
2. 拖拽入口外层包条件渲染
3. 删除/复制按钮按 `isCode && !canEditCodeBlock` 隐藏

(因 H5 文件结构与 PC 一致,改动一一对应。)

- [ ] **Step 10.3: 检查 H5 是否有独立 ConfigSetting**

Run:
```bash
cd /Users/tengyongzhi/work/bot-workspaces/meedu-workspaces/meedu2 && cat xyz.meedu.admin/src/pages/decoration/components/h5/config/index.tsx
```
Expected: 看到类似 PC 的 switch-by-sign 渲染。若存在 `block.sign === 'code'` 分支,按 Task 9 Step 9.4 同样模式加权限判断;若不存在(H5 可能在别处),跳过本步。

- [ ] **Step 10.4: 编译验证**

Run:
```bash
cd xyz.meedu.admin && npm run build
```
Expected: 编译成功。

- [ ] **Step 10.5: 提交**

```bash
git add xyz.meedu.admin/src/pages/decoration/h5.tsx xyz.meedu.admin/src/pages/decoration/components/h5/config/index.tsx
git commit -m "修复:[Admin]H5 装修页代码块入口按权限收紧"
```

---

## Task 11:CHANGELOG

**Files:**
- Modify: `CHANGELOG.md`

- [ ] **Step 11.1: 追加条目**

打开 `CHANGELOG.md`,在最新版本块的开头追加:

```
- 修复:[API/Admin]用户协议(服务/隐私/付费内容)与装修代码块加固 XSS 风险 —— 协议保存时启用 HTMLPurifier 白名单,新增 Artisan 命令 `agreement:sanitize-history` 净化存量;装修代码块编辑新增 `decorationPage.codeBlockEdit` 权限,默认仅超管可用。
```

(如 CHANGELOG 用版本号分块,放当前未发布版本下;否则放最顶部。)

- [ ] **Step 11.2: 提交**

```bash
git add CHANGELOG.md
git commit -m "补充 CHANGELOG:[API/Admin]协议与装修代码块 XSS 加固"
```

---

## Task 12:上线核对清单

- [ ] **Step 12.1: 跑一次全量后端测试**

Run:
```bash
cd xyz.meedu.api && ./vendor/bin/phpunit
```
Expected: 全绿(若已有失败用例不属于本次改动,记录但不阻断)。

- [ ] **Step 12.2: 部署前在生产 / staging 上执行**

```bash
cd xyz.meedu.api
php artisan db:seed --class=AdministratorPermissionSeeder --no-interaction
php artisan agreement:sanitize-history --dry-run
# 人工确认 dry-run 输出无误后:
php artisan agreement:sanitize-history
```

- [ ] **Step 12.3: 人工冒烟**

- 用普通管理员登录 admin,装修页面应**看不到"代码块"拖拽入口**;对已有 code block 应**看不到删除/复制按钮**
- 用超管登录,以上能力恢复
- 后台保存一份含 `<script>alert(1)</script>` 的协议,通过 `/protocol` 页面访问,确认不弹窗
- C 端首页若已有 code block 渲染,内容应与改动前一致

---

## Self-Review 笔记(写计划者自查)

- **Spec 覆盖**:
  - Spec §3 协议净化 → Tasks 1~4 ✅
  - Spec §3.2 存量数据迁移 → Tasks 3~4(含 dry-run) ✅
  - Spec §3.3 Blade 模板保持不变 → 无任务(故意不动) ✅
  - Spec §4.1 后端权限设计 → Tasks 5~8 ✅
  - Spec §4.2 Admin 前端 → Tasks 9~10 ✅
  - Spec §4.3 用户端不改动 → 无任务 ✅
  - Spec §5 上线步骤 → Tasks 11~12 ✅
- **Placeholder scan**:Task 10 Step 10.2 / 10.3 留了"看现状再改"的指引,但每条都附了 Run 命令和对应 DOM 模式参考,不是空头 TODO。
- **类型一致性**:`decorationPage.codeBlockEdit` slug 在常量 / seeder / 控制器 / 前端 / 测试 中拼写一致 ✅。`AdminPermissionBus::isSuperAdmin` / `hasPermissionBySlug` 签名以源码为准 ✅。
