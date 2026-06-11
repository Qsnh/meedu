# 超级管理员初始化向导 — 实现计划

> **For agentic workers:** REQUIRED SUB-SKILL: Use superpowers:subagent-driven-development (recommended) or superpowers:executing-plans to implement this plan task-by-task. Steps use checkbox (`- [ ]`) syntax for tracking.

**Goal:** 把"初次安装产生默认 `meedu@meedu.meedu / meedu123` 超管"替换为"首次访问后台时由真人在 SPA 引导内创建超管"。

**Architecture:** 后端新增两条公开路由 `GET /backend/api/v1/system/setup-status` 与 `POST /backend/api/v1/system/setup`；install.php 不再静默初始化超管；后台 SPA 启动门先查 `setup-status`，`needs_init=true` 时强制路由到新页 `/setup`，完成后回登录页用刚设的密码登录。

**Tech Stack:** PHP/Laravel（xyz.meedu.api）+ React 18 / Antd 5 / Redux Toolkit / react-router-dom 6（xyz.meedu.admin）+ PHPUnit。

**参考 Spec:** `docs/superpowers/specs/2026-06-10-admin-setup-wizard-design.md`

---

## 文件结构（实施前先对照）

### 后端 `xyz.meedu.api`

- **新增** `app/Http/Requests/Backend/SystemSetupRequest.php` — 表单验证类
- **新增** `app/Http/Controllers/Backend/Api/V1/SystemSetupController.php` — 控制器，含 `status()` 与 `setup()`
- **修改** `routes/backend-v1.php` — 在文件顶部"公开路由"区域加入两条 setup 路由
- **修改** `public/install.php` — 删除 `install administrator -q` 调用、Step 2 文案改写
- **新增** `tests/Api/Backend/SystemSetupStatusTest.php`
- **新增** `tests/Api/Backend/SystemSetupTest.php`

### 前端 `xyz.meedu.admin`

- **新增** `src/api/setup.ts` — 两个接口封装
- **修改** `src/api/index.ts` — 导出 `setup`
- **新增** `src/store/system/systemSetupSlice.ts` — `needsInit` 状态
- **修改** `src/store/index.ts` — 注册 reducer
- **新增** `src/pages/setup/index.tsx` — 单卡片向导页
- **新增** `src/pages/setup/index.module.scss` — 与登录页同语言的样式
- **修改** `src/App.tsx` — 在 `<Views />` 前挂启动门
- **修改** `src/routes/index.tsx` — 添加 `/setup` 路由，移除"模块加载期直接 `window.location.href = '/login'`"逻辑（交给启动门）
- **修改** `src/pages/login/index.tsx` — 读取 URL `email` 预填，密码框 `autoFocus`

---

## 通用约定

- 所有提交信息使用与项目一致的中文前缀：`新增:[模块]…` / `修复:[模块]…` / `修改:[模块]…` / `文档:[Spec]…` / `测试:[模块]…`。
- 每完成一个 Task 立即 commit；不要把多个 Task 合并提交。
- 后端测试执行：在 `xyz.meedu.api/` 目录运行 `vendor/bin/phpunit --filter <TestClass>`。
- 前端无单测设施，最后一个 Task 用手测清单替代。

---

## Task 1 — 后端 `SystemSetupRequest` 表单验证类

**Files:**
- Create: `xyz.meedu.api/app/Http/Requests/Backend/SystemSetupRequest.php`

- [ ] **Step 1.1: 创建 SystemSetupRequest 文件**

```php
<?php

/*
 * This file is part of the MeEdu.
 *
 * (c) 杭州白书科技有限公司
 */

namespace App\Http\Requests\Backend;

class SystemSetupRequest extends BaseRequest
{
    public function rules()
    {
        return [
            'name' => 'bail|required|string|between:2,20',
            'email' => 'bail|required|email|max:100',
            'password' => 'bail|required|string|between:8,32|regex:/^(?=.*[A-Za-z])(?=.*\d).+$/|confirmed',
        ];
    }

    public function messages()
    {
        return [
            'name.required' => '请输入姓名',
            'name.between' => '姓名长度为 2-20 个字符',
            'email.required' => '请输入邮箱',
            'email.email' => '请输入合法邮箱',
            'password.required' => '请输入密码',
            'password.between' => '密码长度为 8-32 个字符',
            'password.regex' => '密码必须同时包含字母和数字',
            'password.confirmed' => '两次输入的密码不一致',
        ];
    }

    public function filldata()
    {
        return [
            'name' => $this->input('name'),
            'email' => $this->input('email'),
            'password' => \Illuminate\Support\Facades\Hash::make($this->input('password')),
        ];
    }
}
```

- [ ] **Step 1.2: 提交**

```bash
git add xyz.meedu.api/app/Http/Requests/Backend/SystemSetupRequest.php
git commit -m "新增:[API]增加超管初始化向导表单验证类"
```

---

## Task 2 — 后端 `SystemSetupController::status()` (TDD)

**Files:**
- Create: `xyz.meedu.api/tests/Api/Backend/SystemSetupStatusTest.php`
- Create: `xyz.meedu.api/app/Http/Controllers/Backend/Api/V1/SystemSetupController.php`

- [ ] **Step 2.1: 先写失败的测试**

`xyz.meedu.api/tests/Api/Backend/SystemSetupStatusTest.php`:

```php
<?php

/*
 * This file is part of the MeEdu.
 *
 * (c) 杭州白书科技有限公司
 */

namespace Tests\Api\Backend;

use App\Models\Administrator;

class SystemSetupStatusTest extends Base
{
    public function test_admin_table_empty_returns_needs_init_true()
    {
        // 清空 admin 表，模拟全新部署
        Administrator::query()->delete();

        $response = $this->getJson(self::API_V1_PREFIX . '/system/setup-status');
        $data = $this->assertResponseSuccess($response);
        $this->assertTrue($data['data']['needs_init']);
    }

    public function test_admin_table_non_empty_returns_needs_init_false()
    {
        Administrator::factory()->create();

        $response = $this->getJson(self::API_V1_PREFIX . '/system/setup-status');
        $data = $this->assertResponseSuccess($response);
        $this->assertFalse($data['data']['needs_init']);
    }
}
```

- [ ] **Step 2.2: 运行测试确认失败**

```bash
cd xyz.meedu.api && vendor/bin/phpunit --filter SystemSetupStatusTest
```
Expected: 2 个用例报 404 或路由不存在错误。

- [ ] **Step 2.3: 创建控制器，仅实现 `status()`**

`xyz.meedu.api/app/Http/Controllers/Backend/Api/V1/SystemSetupController.php`:

```php
<?php

/*
 * This file is part of the MeEdu.
 *
 * (c) 杭州白书科技有限公司
 */

namespace App\Http\Controllers\Backend\Api\V1;

use App\Models\Administrator;

class SystemSetupController extends BaseController
{
    public function status()
    {
        $needsInit = Administrator::query()->doesntExist();
        return $this->successData(['needs_init' => $needsInit]);
    }
}
```

- [ ] **Step 2.4: 在 backend-v1.php 顶部公开路由区域增加 GET 路由（仅本步骤所需）**

修改 `xyz.meedu.api/routes/backend-v1.php`，在 `Route::get('/captcha/image', ...)` 后追加：

```php
Route::get('/system/setup-status', 'SystemSetupController@status');
```

- [ ] **Step 2.5: 运行测试确认通过**

```bash
cd xyz.meedu.api && vendor/bin/phpunit --filter SystemSetupStatusTest
```
Expected: 2 passed。

- [ ] **Step 2.6: 提交**

```bash
git add xyz.meedu.api/app/Http/Controllers/Backend/Api/V1/SystemSetupController.php \
        xyz.meedu.api/routes/backend-v1.php \
        xyz.meedu.api/tests/Api/Backend/SystemSetupStatusTest.php
git commit -m "新增:[API]增加超管初始化状态查询接口"
```

---

## Task 3 — 后端 `SystemSetupController::setup()` (TDD)

**Files:**
- Create: `xyz.meedu.api/tests/Api/Backend/SystemSetupTest.php`
- Modify: `xyz.meedu.api/app/Http/Controllers/Backend/Api/V1/SystemSetupController.php`
- Modify: `xyz.meedu.api/routes/backend-v1.php`

- [ ] **Step 3.1: 写失败的测试**

`xyz.meedu.api/tests/Api/Backend/SystemSetupTest.php`:

```php
<?php

/*
 * This file is part of the MeEdu.
 *
 * (c) 杭州白书科技有限公司
 */

namespace Tests\Api\Backend;

use App\Models\Administrator;
use App\Models\AdministratorRole;
use Illuminate\Support\Facades\Hash;

class SystemSetupTest extends Base
{
    protected function setUp(): void
    {
        parent::setUp();
        // 确保 super 角色存在（install role 已落地，但测试环境每跑一次都重建库）
        AdministratorRole::query()->firstOrCreate(
            ['slug' => config('meedu.administrator.super_slug')],
            ['display_name' => '超级管理员', 'description' => '超管']
        );
    }

    public function test_valid_request_creates_super_admin()
    {
        Administrator::query()->delete();

        $response = $this->postJson(self::API_V1_PREFIX . '/system/setup', [
            'name' => '张三',
            'email' => 'zhangsan@example.com',
            'password' => 'StrongPass123',
            'password_confirmation' => 'StrongPass123',
        ]);
        $data = $this->assertResponseSuccess($response);

        $this->assertEquals('zhangsan@example.com', $data['data']['email']);
        $this->assertEquals(1, Administrator::query()->count());

        $admin = Administrator::query()->first();
        $this->assertEquals('张三', $admin->name);
        $this->assertTrue(Hash::check('StrongPass123', $admin->password));

        $superSlug = config('meedu.administrator.super_slug');
        $this->assertTrue($admin->roles()->where('slug', $superSlug)->exists());
    }

    public function test_already_initialized_returns_business_error()
    {
        Administrator::factory()->create();

        $countBefore = Administrator::query()->count();
        $response = $this->postJson(self::API_V1_PREFIX . '/system/setup', [
            'name' => '张三',
            'email' => 'zhangsan@example.com',
            'password' => 'StrongPass123',
            'password_confirmation' => 'StrongPass123',
        ]);
        $this->assertResponseError($response, '系统已完成超管初始化');
        $this->assertEquals($countBefore, Administrator::query()->count());
    }

    public function test_missing_name_returns_validation_error()
    {
        Administrator::query()->delete();
        $response = $this->postJson(self::API_V1_PREFIX . '/system/setup', [
            'email' => 'a@b.com',
            'password' => 'StrongPass123',
            'password_confirmation' => 'StrongPass123',
        ]);
        $this->assertResponseError($response);
    }

    public function test_password_mismatch_returns_validation_error()
    {
        Administrator::query()->delete();
        $response = $this->postJson(self::API_V1_PREFIX . '/system/setup', [
            'name' => '张三',
            'email' => 'a@b.com',
            'password' => 'StrongPass123',
            'password_confirmation' => 'OtherPass123',
        ]);
        $this->assertResponseError($response);
    }

    public function test_weak_password_returns_validation_error()
    {
        Administrator::query()->delete();
        $response = $this->postJson(self::API_V1_PREFIX . '/system/setup', [
            'name' => '张三',
            'email' => 'a@b.com',
            'password' => 'onlyletters',
            'password_confirmation' => 'onlyletters',
        ]);
        $this->assertResponseError($response);
    }

    public function test_invalid_email_returns_validation_error()
    {
        Administrator::query()->delete();
        $response = $this->postJson(self::API_V1_PREFIX . '/system/setup', [
            'name' => '张三',
            'email' => 'not-an-email',
            'password' => 'StrongPass123',
            'password_confirmation' => 'StrongPass123',
        ]);
        $this->assertResponseError($response);
    }
}
```

- [ ] **Step 3.2: 运行测试确认失败**

```bash
cd xyz.meedu.api && vendor/bin/phpunit --filter SystemSetupTest
```
Expected: 全部失败（路由 404 或方法未实现）。

- [ ] **Step 3.3: 在控制器中实现 `setup()`**

在 `SystemSetupController.php` 顶部追加 use：

```php
use App\Models\AdministratorRole;
use Illuminate\Support\Facades\DB;
use App\Http\Requests\Backend\SystemSetupRequest;
```

在类内增加方法：

```php
public function setup(SystemSetupRequest $request)
{
    $superSlug = config('meedu.administrator.super_slug');
    $errorMessage = null;
    $createdEmail = null;

    DB::transaction(function () use ($request, $superSlug, &$errorMessage, &$createdEmail) {
        // 悲观锁防并发抢号
        $exists = Administrator::query()->lockForUpdate()->exists();
        if ($exists) {
            $errorMessage = '系统已完成超管初始化';
            return;
        }

        $super = AdministratorRole::query()->where('slug', $superSlug)->first();
        if (!$super) {
            $errorMessage = '系统角色数据缺失，请先运行 php artisan install role';
            return;
        }

        $payload = $request->filldata();
        $admin = Administrator::query()->create($payload);
        $admin->roles()->attach($super->id);
        $createdEmail = $admin->email;
    });

    if ($errorMessage !== null) {
        return $this->error($errorMessage);
    }

    return $this->successData(['email' => $createdEmail]);
}
```

- [ ] **Step 3.4: 在 backend-v1.php 顶部公开路由区域追加 POST 路由**

在 Task 2 添加的 GET 路由下方追加：

```php
Route::post('/system/setup', 'SystemSetupController@setup');
```

- [ ] **Step 3.5: 运行测试确认通过**

```bash
cd xyz.meedu.api && vendor/bin/phpunit --filter SystemSetupTest
```
Expected: 6 passed。

- [ ] **Step 3.6: 提交**

```bash
git add xyz.meedu.api/app/Http/Controllers/Backend/Api/V1/SystemSetupController.php \
        xyz.meedu.api/routes/backend-v1.php \
        xyz.meedu.api/tests/Api/Backend/SystemSetupTest.php
git commit -m "新增:[API]增加超管初始化提交接口"
```

---

## Task 4 — install.php 改造

**Files:**
- Modify: `xyz.meedu.api/public/install.php`

- [ ] **Step 4.1: 移除 `install administrator -q` 调用**

在 `install.php` 中定位以下代码块（约 Step 1 数据库写入完成后）：

```php
// install administrator
$artisan->call('install', ['action' => 'administrator', '-q' => true], $output);
```

整行删除（包括上方注释）。保留前后的 `install role`、`install config`、`storage:link`、`key:generate`、`jwt:secret`、`migrate` 调用不动。

- [ ] **Step 4.2: 改写 Step 2 模板**

定位 `} elseif ($step === 2) {` 内的 HTML 模板，把 `<main>` 区块整段替换为：

```html
<main>
    <h2>恭喜！安装成功</h2>
    <div class="success-message">
        <p>MeEdu 程序已经成功安装到您的服务器上。请访问后台完成超管初始化。</p>
    </div>
</main>
```

（删除 `.admin-info` 整块、删除"立即登录修改默认密码"提示。）

- [ ] **Step 4.3: 移除遗弃的 CSS 类**

把同一 Step 2 的 `<style>` 块里 `.admin-info`、`.admin-info h3`、`.admin-info p`、`.warning` 四条规则整段删除（CSS 余量不重要但顺手清理掉，避免后续误用）。

- [ ] **Step 4.4: 手测 install.php Step 2 渲染**

在干净环境下从 step=0 走到 step=2（或直接构造 step=2 URL），确认页面只显示"恭喜！安装成功 + 请访问后台完成超管初始化"，没有任何账号密码字样。

- [ ] **Step 4.5: 提交**

```bash
git add xyz.meedu.api/public/install.php
git commit -m "修改:[API]安装流程不再静默创建默认超管账号"
```

---

## Task 5 — 前端 API 封装

**Files:**
- Create: `xyz.meedu.admin/src/api/setup.ts`
- Modify: `xyz.meedu.admin/src/api/index.ts`

- [ ] **Step 5.1: 创建 setup API**

`xyz.meedu.admin/src/api/setup.ts`:

```ts
import client from "./internal/httpClient";

export function getSetupStatus() {
  return client.get("/backend/api/v1/system/setup-status", {});
}

export function submitSetup(params: {
  name: string;
  email: string;
  password: string;
  password_confirmation: string;
}) {
  return client.post("/backend/api/v1/system/setup", params);
}
```

- [ ] **Step 5.2: 在 api index 中导出**

修改 `xyz.meedu.admin/src/api/index.ts`，在文件末尾追加：

```ts
export * as setup from "./setup";
```

- [ ] **Step 5.3: 提交**

```bash
git add xyz.meedu.admin/src/api/setup.ts xyz.meedu.admin/src/api/index.ts
git commit -m "新增:[Admin]增加超管初始化接口封装"
```

---

## Task 6 — 前端 Redux 状态

**Files:**
- Create: `xyz.meedu.admin/src/store/system/systemSetupSlice.ts`
- Modify: `xyz.meedu.admin/src/store/index.ts`

- [ ] **Step 6.1: 创建 slice**

`xyz.meedu.admin/src/store/system/systemSetupSlice.ts`:

```ts
import { createSlice } from "@reduxjs/toolkit";

type SetupState = {
  needsInit: boolean | null; // null = 尚未查询
};

const initialState: SetupState = { needsInit: null };

const systemSetupSlice = createSlice({
  name: "systemSetup",
  initialState,
  reducers: {
    setNeedsInit(state, action: { payload: boolean }) {
      state.needsInit = action.payload;
    },
  },
});

export default systemSetupSlice.reducer;
export const { setNeedsInit } = systemSetupSlice.actions;
export type { SetupState };
```

- [ ] **Step 6.2: 在 store 中注册**

修改 `xyz.meedu.admin/src/store/index.ts`：

```ts
import { configureStore } from "@reduxjs/toolkit";
import systemConfigReducer from "./system/systemConfigSlice";
import systemSetupReducer from "./system/systemSetupSlice";
import loginUserReducer from "./user/loginUserSlice";
import EnabledAddonsReducer from "./enabledAddons/enabledAddonsConfigSlice";

const store = configureStore({
  reducer: {
    loginUser: loginUserReducer,
    systemConfig: systemConfigReducer,
    systemSetup: systemSetupReducer,
    enabledAddonsConfig: EnabledAddonsReducer,
  },
});

export default store;
```

- [ ] **Step 6.3: 提交**

```bash
git add xyz.meedu.admin/src/store/system/systemSetupSlice.ts xyz.meedu.admin/src/store/index.ts
git commit -m "新增:[Admin]增加超管初始化状态 Redux slice"
```

---

## Task 7 — 前端 `/setup` 向导页

**Files:**
- Create: `xyz.meedu.admin/src/pages/setup/index.tsx`
- Create: `xyz.meedu.admin/src/pages/setup/index.module.scss`

- [ ] **Step 7.1: 创建样式（克隆登录页排版）**

`xyz.meedu.admin/src/pages/setup/index.module.scss`:

```scss
.setup-container {
  display: flex;
  align-items: center;
  justify-content: center;
  min-height: 100vh;
  background: #f5f5f5;
}

.card {
  width: 480px;
  background: #fff;
  border-radius: 8px;
  box-shadow: 0 2px 12px rgba(0, 0, 0, 0.08);
  padding: 48px 40px;
}

.logo {
  display: flex;
  justify-content: center;
  margin-bottom: 16px;
  img { height: 40px; }
}

.title {
  text-align: center;
  font-size: 20px;
  font-weight: 600;
  color: #1f1f1f;
  margin-bottom: 4px;
}

.subtitle {
  text-align: center;
  font-size: 14px;
  color: #8c8c8c;
  margin-bottom: 32px;
}

.submit {
  width: 100%;
  height: 48px;
  font-size: 16px;
}
```

- [ ] **Step 7.2: 创建页面**

`xyz.meedu.admin/src/pages/setup/index.tsx`:

```tsx
import { useState } from "react";
import { Form, Input, Button, message } from "antd";
import { useNavigate } from "react-router-dom";
import { useDispatch } from "react-redux";
import { setup as setupApi } from "../../api";
import { setNeedsInit } from "../../store/system/systemSetupSlice";
import styles from "./index.module.scss";

type FormValues = {
  name: string;
  email: string;
  password: string;
  password_confirmation: string;
};

const SetupPage = () => {
  document.title = "初始化超级管理员";
  const navigate = useNavigate();
  const dispatch = useDispatch();
  const [form] = Form.useForm<FormValues>();
  const [loading, setLoading] = useState(false);

  const onFinish = async (values: FormValues) => {
    if (loading) return;
    setLoading(true);
    try {
      const res: any = await setupApi.submitSetup(values);
      const email = res?.data?.email ?? values.email;
      dispatch(setNeedsInit(false));
      message.success("超级管理员创建成功，请登录");
      navigate(`/login?email=${encodeURIComponent(email)}`, { replace: true });
    } catch {
      // 业务错误已被 axios 拦截器 toast；这里只需判定是否系统状态变化
      try {
        const statusRes: any = await setupApi.getSetupStatus();
        if (statusRes?.data?.needs_init === false) {
          dispatch(setNeedsInit(false));
          navigate("/login", { replace: true });
        }
      } catch {
        // 状态查询本身失败，让用户重试
      }
      setLoading(false);
    }
  };

  return (
    <div className={styles["setup-container"]}>
      <div className={styles["card"]}>
        <div className={styles["logo"]}>
          <img src="/images/logo.png" alt="MeEdu" />
        </div>
        <div className={styles["title"]}>欢迎使用 MeEdu</div>
        <div className={styles["subtitle"]}>请创建首位超级管理员账号</div>

        <Form
          form={form}
          layout="vertical"
          onFinish={onFinish}
          autoComplete="off"
        >
          <Form.Item
            label="姓名"
            name="name"
            rules={[
              { required: true, message: "请输入姓名" },
              { min: 2, max: 20, message: "姓名长度为 2-20 个字符" },
            ]}
          >
            <Input placeholder="请输入姓名" />
          </Form.Item>

          <Form.Item
            label="邮箱"
            name="email"
            rules={[
              { required: true, message: "请输入邮箱" },
              { type: "email", message: "请输入合法邮箱" },
            ]}
          >
            <Input placeholder="用作登录账号" />
          </Form.Item>

          <Form.Item
            label="密码"
            name="password"
            extra="8-32 位，至少包含字母和数字"
            rules={[
              { required: true, message: "请输入密码" },
              { min: 8, max: 32, message: "密码长度为 8-32 个字符" },
              {
                pattern: /^(?=.*[A-Za-z])(?=.*\d).+$/,
                message: "密码必须同时包含字母和数字",
              },
            ]}
          >
            <Input.Password placeholder="请输入密码" />
          </Form.Item>

          <Form.Item
            label="确认密码"
            name="password_confirmation"
            dependencies={["password"]}
            rules={[
              { required: true, message: "请再次输入密码" },
              ({ getFieldValue }) => ({
                validator(_, value) {
                  if (!value || getFieldValue("password") === value) {
                    return Promise.resolve();
                  }
                  return Promise.reject(new Error("两次输入的密码不一致"));
                },
              }),
            ]}
          >
            <Input.Password placeholder="再次输入密码" />
          </Form.Item>

          <Form.Item>
            <Button
              type="primary"
              htmlType="submit"
              loading={loading}
              className={styles["submit"]}
            >
              创建并登录
            </Button>
          </Form.Item>
        </Form>
      </div>
    </div>
  );
};

export default SetupPage;
```

- [ ] **Step 7.3: 提交**

```bash
git add xyz.meedu.admin/src/pages/setup/
git commit -m "新增:[Admin]增加超管初始化向导页面"
```

---

## Task 8 — 注册 `/setup` 路由 + 调整启动期跳转逻辑

**Files:**
- Modify: `xyz.meedu.admin/src/routes/index.tsx`

> 现有 `routes/index.tsx` 在模块加载时同步执行 `window.location.href = "/login"`（约第 172-179 行），会与 `/setup` 守卫冲突，需要把白名单加上 `"/setup"`，等启动门来决定方向。

- [ ] **Step 8.1: 在 lazy 导入区追加 SetupPage**

在文件顶部 lazy 区域（例如 `EditConfigPage` 旁边）追加：

```ts
const SetupPage = lazy(() => import("../pages/setup"));
```

- [ ] **Step 8.2: 放宽启动期 location.href 白名单**

将这一段（约第 172-179 行）：

```ts
if (
  window.location.pathname !== "/login" &&
  window.location.pathname !== "/edit-config" &&
  window.location.pathname !== "/error"
) {
  window.location.href = "/login";
}
```

改为：

```ts
if (
  window.location.pathname !== "/login" &&
  window.location.pathname !== "/edit-config" &&
  window.location.pathname !== "/error" &&
  window.location.pathname !== "/setup"
) {
  window.location.href = "/login";
}
```

- [ ] **Step 8.3: 注册 `/setup` 路由**

在使用 `WithoutHeaderWithoutFooter` 的 children 数组中（`/login` 旁边）插入：

```ts
{
  path: "/setup",
  element: <SetupPage />,
},
```

- [ ] **Step 8.4: 本地起前端 dev 验证编译通过**

```bash
cd xyz.meedu.admin && pnpm dev
```
访问 `http://localhost:<port>/setup`，应能渲染出表单（暂未挂启动门，路由能直达即可）。Ctrl+C 关停。

- [ ] **Step 8.5: 提交**

```bash
git add xyz.meedu.admin/src/routes/index.tsx
git commit -m "新增:[Admin]注册 /setup 路由并放宽启动白名单"
```

---

## Task 9 — 前端启动门（先于路由判定）

**Files:**
- Modify: `xyz.meedu.admin/src/App.tsx`

- [ ] **Step 9.1: 改写 App.tsx**

完整覆盖 `xyz.meedu.admin/src/App.tsx`：

```tsx
import { useEffect, useState } from "react";
import { useRoutes } from "react-router-dom";
import { useDispatch } from "react-redux";
import { Spin } from "antd";
import routes from "./routes";
import "./App.scss";
import { Suspense } from "react";
import LoadingPage from "./pages/loading";
import { setup as setupApi } from "./api";
import { setNeedsInit } from "./store/system/systemSetupSlice";
import { clearToken } from "./utils";

function App() {
  const Views = () => useRoutes(routes);
  const dispatch = useDispatch();
  const [gateReady, setGateReady] = useState(false);
  const [gateError, setGateError] = useState(false);

  useEffect(() => {
    let cancelled = false;
    setupApi
      .getSetupStatus()
      .then((res: any) => {
        if (cancelled) return;
        const needsInit = Boolean(res?.data?.needs_init);
        dispatch(setNeedsInit(needsInit));
        if (needsInit) {
          // 清除可能残留的 token，避免旧 token 把用户挡在 setup 之外
          clearToken();
          if (
            window.location.pathname !== "/setup" &&
            window.location.pathname !== "/error"
          ) {
            window.location.replace("/setup");
            return;
          }
        } else {
          if (window.location.pathname === "/setup") {
            window.location.replace("/login");
            return;
          }
        }
        setGateReady(true);
      })
      .catch(() => {
        if (cancelled) return;
        setGateError(true);
      });
    return () => {
      cancelled = true;
    };
  }, [dispatch]);

  if (gateError) {
    return (
      <div
        style={{
          minHeight: "100vh",
          display: "flex",
          alignItems: "center",
          justifyContent: "center",
          flexDirection: "column",
          gap: 16,
        }}
      >
        <div>系统状态获取失败，请刷新重试</div>
      </div>
    );
  }

  if (!gateReady) {
    return (
      <div
        style={{
          minHeight: "100vh",
          display: "flex",
          alignItems: "center",
          justifyContent: "center",
        }}
      >
        <Spin size="large" />
      </div>
    );
  }

  return (
    <Suspense fallback={<LoadingPage />}>
      <Views />
    </Suspense>
  );
}

export default App;
```

- [ ] **Step 9.2: 本地起前端验证两种状态**

```bash
cd xyz.meedu.admin && pnpm dev
```

- 数据库无管理员：访问 `/admin` → 自动跳 `/setup`。
- 至少 1 个管理员：访问 `/admin` → 走原有 login/dashboard 路径；手动访问 `/setup` → 自动跳 `/login`。

Ctrl+C 关停。

- [ ] **Step 9.3: 提交**

```bash
git add xyz.meedu.admin/src/App.tsx
git commit -m "新增:[Admin]增加启动门拦截未初始化系统并引导到 /setup"
```

---

## Task 10 — 登录页支持 query email 预填 + autoFocus 密码框

**Files:**
- Modify: `xyz.meedu.admin/src/pages/login/index.tsx`

- [ ] **Step 10.1: 引入 useSearchParams 与 ref**

在 `pages/login/index.tsx` 顶部 import 区追加：

```ts
import { useRef } from "react";
import { useSearchParams } from "react-router-dom";
import type { InputRef } from "antd";
```

注意 `useState`、`useEffect` 等保持原有；`useRef` 与 React 同源已在原 import 中（如未导入则一并加入）。

- [ ] **Step 10.2: 在组件内增加 ref 与读取 query**

在 `const [captchaLoading, setCaptchaLoading] = useState(true);` 下方追加：

```ts
const passwordRef = useRef<InputRef>(null);
const [searchParams] = useSearchParams();
```

- [ ] **Step 10.3: 在已有 useEffect 之后追加新的 useEffect**

```ts
useEffect(() => {
  const presetEmail = searchParams.get("email");
  if (presetEmail) {
    setEmail(presetEmail);
    setTimeout(() => passwordRef.current?.focus(), 0);
  }
  // eslint-disable-next-line react-hooks/exhaustive-deps
}, []);
```

- [ ] **Step 10.4: 把 ref 绑到密码框**

将原有 `<Input.Password ... />` 标签上追加 `ref={passwordRef}` 属性（保留其余属性不变）。

- [ ] **Step 10.5: 本地手测**

```bash
cd xyz.meedu.admin && pnpm dev
```
访问 `/login?email=foo@bar.com` → 邮箱输入框预填 `foo@bar.com`，焦点落在密码框。

- [ ] **Step 10.6: 提交**

```bash
git add xyz.meedu.admin/src/pages/login/index.tsx
git commit -m "新增:[Admin]登录页支持邮箱预填和密码框自动聚焦"
```

---

## Task 11 — 端到端手测与回归

> 前端没有自动化测试，本 Task 是上线前的最终验收清单。失败任一项则回到对应 Task 修复。

**全新部署路径**

- [ ] **Step 11.1: 准备环境**

清空 admin 表：
```bash
cd xyz.meedu.api && php artisan tinker --execute "App\Models\Administrator::query()->delete();"
```

启动 API + Admin：
```bash
cd xyz.meedu.api && php artisan serve --port=8000 &
cd xyz.meedu.admin && pnpm dev
```

- [ ] **Step 11.2: 访问 /admin → 跳 /setup**

浏览器打开 admin SPA 根路径，应立即被替换为 `/setup`，看到欢迎卡片与 4 个字段。

- [ ] **Step 11.3: 表单客户端校验**

- 留空提交 → 各 Form.Item 标红"请输入…"。
- 邮箱写 `not-an-email` → 标"请输入合法邮箱"。
- 密码写 `abc` → 标"密码长度为 8-32 个字符"。
- 密码写 `onlyletters` → 标"密码必须同时包含字母和数字"。
- 密码 `Pass1234`、确认 `Pass5678` → 标"两次输入的密码不一致"。

- [ ] **Step 11.4: 合法提交并验证跳转**

填 `张三 / zhangsan@example.com / StrongPass123 / StrongPass123` → 提交。预期：toast"超级管理员创建成功，请登录" + 跳到 `/login?email=zhangsan@example.com`，邮箱已预填，焦点在密码框。

- [ ] **Step 11.5: 用刚设的密码登录**

继续登录 → 进入正常的 dashboard / edit-config 流程。

- [ ] **Step 11.6: 反向守卫**

完成 11.5 之后，手动在地址栏敲 `/setup` → 立刻被替换为 `/login`。

- [ ] **Step 11.7: install.php 文案核对**

直接打开 `<URL>/install.php?step=2` → 页面仅显示"恭喜！安装成功 + 请访问后台完成超管初始化"，无账号密码字样。

**老站升级回归路径**

- [ ] **Step 11.8: 装一份 admin 表非空的旧库**

恢复至少一个 admin 行（可保留 11.4 创建的账号）。访问 `/admin` → 走原有 login 流程，无 setup 干扰。手动敲 `/setup` → 跳 `/login`。

- [ ] **Step 11.9: 命令行救援场景**

清空 admin 表 → 在服务器命令行运行 `php artisan install administrator`，按提示输入。完成后访问 `/admin` → 直接走原有 login 流程，setup 向导不再出现。

- [ ] **Step 11.10: 把手测结论写入 PR 描述**

在 PR 描述中列出 11.1-11.9 全部 ✅，附 1-2 张关键截图（`/setup` 卡片 + Step 2 新文案）。

---

## 自检

### 1. Spec 覆盖度
- 后端两接口 → Task 2/3
- 业务保护（lockForUpdate）→ Task 3 Step 3.3
- install.php 改造 → Task 4
- 命令行救援保留 → 默认（无任何文件改动）
- 前端启动门 → Task 9
- 反向守卫 → Task 9 Step 9.1（已初始化时访问 /setup 跳 /login）
- /setup 单卡片 → Task 7
- 登录页邮箱预填 + autoFocus → Task 10
- 边界场景 1-8 → Task 11 覆盖了 1/2(单端模拟)/4/5/7/8；3(断网回滚)/6(状态接口失败) 通过 Task 9 的 gateError UI 验证可手测

### 2. Placeholder scan
- 全文无 TBD/TODO/"add appropriate error handling"。
- 每个步骤都给出具体代码或具体命令。

### 3. 类型/命名一致性
- `setNeedsInit` action 在 Task 6 定义、Task 7 和 Task 9 使用 — 一致。
- `setupApi.getSetupStatus()` / `setupApi.submitSetup()` 命名贯穿 Task 5/7/9 — 一致。
- `SystemSetupController::status() / setup()` 与路由路径 `/system/setup-status` / `/system/setup` 一致（Task 2/3）。
- `super_slug` 来源 `config('meedu.administrator.super_slug')`，与现有 `ApplicationInstallCommand` 用法一致。
