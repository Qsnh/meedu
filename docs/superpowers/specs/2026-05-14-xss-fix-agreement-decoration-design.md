# 用户协议与装修代码块 XSS 修复 — 设计文档

- 日期:2026-05-14
- 范围:`xyz.meedu.api`、`xyz.meedu.admin`
- 不在范围(后续单独任务):课程评论、系统公告、课程描述等其他使用 `dangerouslySetInnerHTML` / `{!! !!}` 的位置

## 1. 背景

在 meedu 项目代码调研中,定位到两组 XSS 风险:

**用户协议类**(服务协议 / 隐私协议 / 付费内容购买协议):
- 后端 Blade 模板以 `{!! $protocol !!}` 形式直接输出协议正文
  - `xyz.meedu.api/resources/views/index/user_protocol.blade.php`(行 2、14)
  - `xyz.meedu.api/resources/views/index/user_private_protocol.blade.php`(行 11)
  - `xyz.meedu.api/resources/views/index/paid_content_purchase_protocol.blade.php`(行 11)
- 后台保存协议时无 HTML 净化,直接落库
  - `xyz.meedu.api/app/Http/Requests/Backend/AgreementRequest.php`(`content` 字段仅做 `required|string`)
- 项目里已经有 `config/purifier.php`(`mews/purifier` 包配置),但协议保存/渲染均未启用

**装修代码块**(`ViewBlock.sign === 'code'`,PC 装修和 H5 装修都有该块类型):
- 前端 PC 落地页 `xyz.meedu.pc/src/pages/index/index.tsx`(行 222)以 `dangerouslySetInnerHTML` 渲染管理员录入的任意 HTML/JS
- Admin 装修预览组件 `xyz.meedu.admin/src/pages/decoration/components/pc/render-code/index.tsx`(行 16)同样直接渲染
- Admin H5 端代码块配置:`xyz.meedu.admin/src/pages/decoration/components/h5/config/code.tsx`
- 后台 `ViewBlockController` 的 `store / update` 仅对 `config` 做 `json_encode`,无任何校验
- 当前所有装修块共用一个权限 `decorationPage.blocks`,只要能编辑装修页就能注入任意脚本

## 2. 总体策略

针对两类内容的本质差异,采用差异化策略:

| 模块 | 策略 | 原因 |
|------|------|------|
| 用户协议 | **内容白名单过滤**(保存时净化) | 协议是法律文案,不需要 JS;`config/purifier.php` 已配好 |
| 装修代码块 | **权限隔离**(新增 super-admin-only 权限) | 代码块"执行 JS"是产品必需能力(嵌入统计、客服等),不能净化内容,只能从来源端收紧 |

威胁模型:
- **协议**:目标是阻断任何注入(法律内容不该有 JS,任何 JS 都视为攻击)
- **代码块**:目标是收敛"能注入 JS"的人员范围,避免低权限管理员或被钓鱼的普通账号污染面向 C 端用户的页面

## 3. 用户协议模块 — 详细设计

### 3.1 保存侧:HTMLPurifier 净化

修改文件:`xyz.meedu.api/app/Http/Requests/Backend/AgreementRequest.php`

在 `filldata()` 中,对 `content` 字段调用 `Purifier::clean($content, 'default')` 后再返回。使用项目已有的 `default` profile —— 该 profile 允许 `p / strong / em / ul / ol / li / a[href|title] / img[src|width|height|alt] / h2~h6 / blockquote / table` 等常用排版标签,**禁止** `<script>`、`<iframe>`(默认未开启 `HTML.SafeIframe`)、`on*` 事件属性、`javascript:` 协议。

净化时机选择:**保存时净化、渲染信任**(trust-on-write)。理由:
- 渲染发生在每次访问协议页,远高于保存频率,在渲染时调用 Purifier 浪费资源
- 净化后入库的内容可信任,Blade 模板继续用 `{!! !!}` 不变
- 配合存量数据迁移,渲染侧无遗留风险

### 3.2 存量数据迁移

新增 Artisan 命令:`xyz.meedu.api/app/Console/Commands/AgreementSanitizeCommand.php`

- 命令签名:`agreement:sanitize-history`
- 逻辑:
  1. 遍历 `agreements` 表全部记录
  2. 对每条记录的 `content` 字段调用 `Purifier::clean($content, 'default')`
  3. 仅当净化前后内容不一致时才更新数据库(避免无谓的写)
  4. 净化完成后调用 `ActiveAgreementCache` 的清理方法(或所有 type 的缓存 key),让生效协议下次访问时重新走查询
- 命令执行结果输出:总数 / 改动数 / 失败数

### 3.3 Blade 模板

`{!! $protocol !!}` 形式保留不动。

### 3.4 风险与回滚

- 风险:若历史协议里有意使用了非白名单标签(如 `<center>`),净化后排版会变。**缓解**:迁移命令先 dry-run 输出差异,管理员确认后再执行。
- 回滚:仅需把 `filldata()` 改回原状即可,数据库无 schema 变更。

## 4. 装修代码块模块 — 详细设计

### 4.1 后端权限设计

#### 新增权限常量
文件:`xyz.meedu.api/app/Constant/BackendPermission.php`

```php
public const DECORATION_CODE_BLOCK_EDIT = 'decorationPage.codeBlockEdit';
```

#### 注册到 seeder
文件:`xyz.meedu.api/database/seeders/AdministratorPermissionSeeder.php`

在装修分组下新增:
```php
[
    'display_name' => '装修-代码块编辑',
    'slug' => BackendPermission::DECORATION_CODE_BLOCK_EDIT,
    'sort' => <实施时取一个不与现有装修组冲突的 sort 值;若需要紧跟 DECORATION_PAGE_BLOCKS(当前 sort=2006),把后续装修项的 sort 一并 +1>,
],
```

`AdministratorPermissionSeeder` 需以 `updateOrCreate / firstOrCreate` 形式插入,保证幂等。该权限默认不挂到任何业务角色 —— 普通管理员需后台手动勾选;超管通过 `isSuperAdmin()` 中间件 bypass 自动具备。

#### 控制器层差异化校验
文件:`xyz.meedu.api/app/Http/Controllers/Backend/Api/V1/ViewBlockController.php`

由于 `viewBlock` 系列路由覆盖所有块类型,**不在路由层加新中间件**(否则会误伤其他正常块编辑),而是在控制器方法内按 block 的 `sign` 字段判断:

- `store(Request $request)`:若 `$request->input('sign') === 'code'`,执行 `AdminPermissionBus::hasPermissionBySlug($adminId, BackendPermission::DECORATION_CODE_BLOCK_EDIT)` 校验,无权限返回 403
- `update(Request $request, $id)`:取出目标 `ViewBlock`,若 `$block->sign === 'code'` 或者请求中尝试将其改为 `code`,执行同上校验
- `destroy($id)`:若目标 block 是 `code`,同上校验
- 超管由现有 `AdminPermissionBus::isSuperAdmin()` 自动放行

所有针对 code block 的 create / update / destroy 操作通过现有 `AdministratorLog::storeLog()` 写审计(沿用项目既有审计风格,本次不引入新字段如 IP / diff)。

### 4.2 Admin 前端

#### 权限读取
现有 `xyz.meedu.admin/src/utils/permissionUtil.ts` 的 `PermissionUtil.hasPermission(permissions, slug)` 直接复用。

#### 编辑入口控制
涉及位置:
- PC 装修编辑入口:`xyz.meedu.admin/src/pages/decoration/components/pc/config/index.tsx`(块类型选择)、`xyz.meedu.admin/src/pages/decoration/components/pc/render-code/index.tsx`(已存在的代码块预览/编辑入口)
- H5 装修编辑入口:`xyz.meedu.admin/src/pages/decoration/components/h5/config/index.tsx`、`xyz.meedu.admin/src/pages/decoration/components/h5/config/code.tsx`
- 装修页主壳:`xyz.meedu.admin/src/pages/decoration/pc.tsx`、`xyz.meedu.admin/src/pages/decoration/h5.tsx`

策略:
- 在"添加块"选项中,代码块项在 `decorationPage.codeBlockEdit` 权限缺失时**隐藏**(而非置灰,降低被反向猜测攻击面的可能)
- 已存在代码块的"编辑 / 删除"按钮在权限缺失时隐藏
- 仅前端隐藏并不构成安全防线 —— 真正的拦截在后端控制器

#### 预览渲染
`render-code/index.tsx` 的 `dangerouslySetInnerHTML` 保留不变。预览动作只由当前编辑者触发,源头(谁能写入 code block)已被权限收紧。

### 4.3 用户端(PC / H5)

不改动。用户端代码块继续用 `dangerouslySetInnerHTML` 渲染,这是产品对"自定义第三方脚本"能力的必要交付。

## 5. 上线步骤

1. 合并后端 PR(包含 `AgreementRequest` 净化、`ViewBlockController` 权限校验、`BackendPermission` 常量、`AdministratorPermissionSeeder` 注册、`AgreementSanitizeCommand` 命令)
2. 合并 admin 前端 PR
3. 生产环境部署后端
4. 执行 `php artisan db:seed --class=AdministratorPermissionSeeder`(增量插入新权限)
5. 执行 `php artisan agreement:sanitize-history`(可先 `--dry-run` 看 diff)
6. 部署 admin 前端
7. 在 `CHANGELOG.md` 追加"修复:[Admin/API] 用户协议与装修代码块的 XSS 风险加固"条目(隐去具体攻击向量)

## 6. 不在本次范围

代码调研发现以下位置同样使用 `dangerouslySetInnerHTML` / `{!! !!}` 但**本次不修复**,建议另起独立任务:

- 课程评论(用户生成,风险最高):`xyz.meedu.h5/src/components/course-comments/`、`xyz.meedu.pc/src/components/course-comments/`
- 系统公告(管理员生成):`xyz.meedu.h5/src/pages/announcement/`、`xyz.meedu.pc/src/pages/announcement/`
- 课程描述、课程购买须知(管理员生成):`xyz.meedu.h5/src/pages/course/compenents/tabs/`、`xyz.meedu.pc/src/pages/vod/detail.tsx`

## 7. 测试要点

- **协议**:
  - 后台保存含 `<script>alert(1)</script>` 的协议正文,落库后 `<script>` 被剥除
  - 后台保存 `<a href="javascript:alert(1)">` 的协议正文,落库后 `href` 被剥除
  - 后台保存合法富文本(`<p><strong>...</strong></p>`)不受影响
  - 跑 `agreement:sanitize-history`,存量数据中带 `<script>` 的记录被清理,缓存被刷新
- **装修代码块**:
  - 普通管理员(无新权限)调用 `POST /backend/api/v1/viewBlock/create` 提交 `sign=code` 块 → 403
  - 普通管理员尝试 `PUT` 现有 code 块 → 403
  - 普通管理员对非 code 块的 CRUD 不受影响
  - 超管不受影响,所有 CRUD 正常
  - admin 前端在普通管理员视角下不展示代码块入口
  - 操作审计中能查到 code 块的变更记录
