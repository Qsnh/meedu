# 超级管理员初始化向导 — 设计文档

- 日期：2026-06-10
- 范围：xyz.meedu.api(install.php、SystemSetupController)+ xyz.meedu.admin(SPA 启动门、`/setup` 页、登录页轻改)
- 状态：待评审

## 1. 背景与现状

当前初次安装由 `xyz.meedu.api/public/install.php` 三步向导承担：

1. **Step 0 环境检测** — PHP 版本、扩展、可写目录、危险函数。
2. **Step 1 数据库配置** — 表单填 URL/DB 主机端口库名账密，提交后测连接、写 `.env`、跑 `key:generate`、`jwt:secret`、`storage:link`、`migrate`，再依次执行 `install role`、`install administrator -q`、`install config`。
3. **Step 2 安装完成** — 屏幕硬编码展示 `meedu@meedu.meedu / meedu123`，提示用户尽快修改，落 `storage/install.lock`。

关键问题：

- `install administrator -q` 直接用硬编码邮箱密码静默初始化超管账号，用户没有机会在向导里输入自己的邮箱密码。
- "请立即修改"完全靠用户自觉；登录界面对默认密码无强制改密拦截。
- Step 2 把默认账号密码明文渲染在 HTML 上，本身就是一个轻量泄露面。

## 2. 目标

- 安装结束时数据库中**不存在任何管理员账号**；超管账号由首次进入后台的人通过 SPA 内的向导亲手创建。
- 体验上"低调引导"：四个字段一屏完成，提交后回到登录页用刚设的密码登录一次。
- 不引入新的 schema 变更，保留命令行救援能力，存量升级用户零打扰。

## 3. 关键决策

| 决策 | 取舍 |
|---|---|
| 安装时不创建任何 admin | 账号决定权交给真正的部署者；代价是公网部署存在"抢号窗口"，由文档提醒部署者收敛后台地址 |
| 向导走后台 SPA 而非 install.php | 复用现有 React/Antd 风格，与登录页同一视觉语言；install.php 保持极小代码量 |
| `needs_init` 由 `Administrator::count()` 决定 | 实现最简单，自然兼容命令行救援与老站升级 |
| 提交成功后跳登录页（邮箱预填、焦点落密码框） | 强制"亲手验证一次"，拦住可能的密码输入乌龙 |
| 单屏单卡片视觉 | 4 个字段够轻；和登录页同样的居中卡片语言 |
| 不设安装令牌、不限 IP | 首版接受"先到先得"，将来如需收紧可在不动前端流程的前提下加 token 校验 |

## 4. 整体流程

```
[ install.php Step 0/1 完成 ]
            │
            ▼
[ Step 2（改）: "安装完成，请访问后台完成超管初始化" ]
            │
            ▼
   用户打开 <URL>/admin
            │
            ▼
   SPA 启动门 → GET /backend/api/v1/system/setup-status
            │
            ▼
       needs_init?
        ┌───┴───┐
       是       否
        │       │
        ▼       ▼
   replace("/setup")    维持原有路由（login / dashboard）
        │
        ▼
[ /setup 单卡片向导：姓名 / 邮箱 / 密码 / 确认密码 ]
        │
        ▼
   POST /backend/api/v1/system/setup
        │
   后端原子操作：
   ① 事务内 lockForUpdate 复核 admin 表为空
   ② 创建超管账号（name / email / password）
   ③ 关联 super_slug 角色
   ④ 200 + 邮箱
        │
        ▼
[ 静默 replace("/login?email=<email>") ]
        │
        ▼
[ 登录页读取 query email 预填，密码框 autoFocus ]
        │
        ▼
[ 用户用刚设的密码登录 → /edit-config 配置补全 → Dashboard ]
```

## 5. 后端契约（xyz.meedu.api）

### 5.1 `GET /backend/api/v1/system/setup-status`

- 鉴权：无（SPA 启动时一定要能调通）
- 响应：

  ```json
  { "code": 0, "data": { "needs_init": true } }
  ```

- 判定：`Administrator::query()->count() === 0` 则 `needs_init=true`，否则 `false`。
- 频率：SPA 启动时调一次，`/setup` 提交成功后清前端状态，无需轮询。

### 5.2 `POST /backend/api/v1/system/setup`

- 鉴权：无（前端尚未登录）
- 请求体：

  ```json
  {
    "name": "张三",
    "email": "zhangsan@example.com",
    "password": "P@ssw0rd",
    "password_confirmation": "P@ssw0rd"
  }
  ```

- 字段校验（Laravel validator）：

  | 字段 | 规则 |
  |---|---|
  | name | required / string / 2-20 字符 |
  | email | required / email / 在 administrators 表唯一 |
  | password | required / 8-32 字符 / 至少含字母+数字 / confirmed |

- 业务保护（防并发抢号）：

  ```php
  DB::transaction(function () use ($req) {
      $exists = Administrator::query()->lockForUpdate()->exists();
      if ($exists) {
          abort(409, '系统已完成超管初始化');
      }
      $super = AdministratorRole::query()
          ->where('slug', config('meedu.administrator.super_slug'))
          ->firstOrFail();
      $admin = Administrator::query()->create([
          'name'     => $req['name'],
          'email'    => $req['email'],
          'password' => Hash::make($req['password']),
      ]);
      $admin->roles()->attach($super->id);
  });
  ```

- 成功响应：

  ```json
  { "code": 0, "data": { "email": "zhangsan@example.com" } }
  ```

- 已初始化时再次调用：返回 `409 Conflict`，前端按"状态过期"处理（刷新 + 重判）。

### 5.3 代码位置

- 路由：`xyz.meedu.api/routes/backend-v1.php` 顶部"公开路由"区域（`/login`、`/captcha/image` 旁边）新增两条 setup 路由，不进入 `auth:administrator` 中间件组。
- 控制器：`app/Http/Controllers/Backend/Api/V1/SystemSetupController.php`，方法 `status()` / `setup()`。
- 请求验证类：`app/Http/Requests/Backend/SystemSetupRequest.php`。

### 5.4 install.php 改造

- 删除 `install administrator -q` 调用；保留 `install role`、`install config`。
- Step 2 模板里删掉硬编码账号密码块；文案改为：

  > **恭喜！安装成功**
  > MeEdu 程序已经成功安装到您的服务器上。请访问后台完成超管初始化。

### 5.5 命令行救援

`php artisan install administrator`（交互式）保留不动。如果超管账号被误删或锁号，可从服务器命令行救回。

## 6. 前端设计（xyz.meedu.admin）

### 6.1 技术栈复核

React 18 + Antd 5 + Redux Toolkit + react-router-dom 6。注意：`src/pages/init` 已被占用做"登录后会话引导（Outlet）"，新页面命名为 **`src/pages/setup`**，路由 `/setup`。

### 6.2 启动门

在 `App.tsx`（或现有 `pages/init` / `AutoTop` 入口附近）挂一段最早的启动逻辑。**setup-status 在任何路由判断、任何 token 检查之前调用**，确保"DB 里没有 admin 但浏览器还残留旧 token"的边角不会绕过引导。

```
App 挂载
  │
  ▼
GET /backend/api/v1/system/setup-status
  │
needs_init?
 ┌──┴──┐
是      否
 │      │
 ▼      ▼
clearToken();              交回原有路由（已有 token 走 Outlet
navigate("/setup",          进 dashboard，无 token 走 login）
  { replace: true });
```

要点：

- 启动门**先于路由守卫触发**；请求 pending 时渲染全屏 `<Spin />`，避免登录页一闪。
- 状态写入 Redux `systemSetupSlice.needsInit`，所有路由守卫从这里读，不重复请求。
- `needs_init=true` 分支额外 `clearToken()`，防止运维人为清空 admin 表后，旧 token 又把用户挡在 setup 之外。
- `/setup` 反向守卫：`needsInit === false` 时访问 `/setup` 强制 `replace("/login")`，防止已初始化系统被人手动敲 URL。

### 6.3 `/setup` 页面（单卡片）

```
┌────────────────────────────────────────────────────────────┐
│                                                            │
│        ┌──────────────────────────────────────┐            │
│        │           [ MeEdu Logo ]             │            │
│        │                                      │            │
│        │     欢迎使用 MeEdu                   │            │
│        │     请创建首位超级管理员账号         │            │
│        │                                      │            │
│        │  姓名      ┌────────────────────┐   │            │
│        │            │ 请输入姓名         │   │            │
│        │            └────────────────────┘   │            │
│        │                                      │            │
│        │  邮箱      ┌────────────────────┐   │            │
│        │            │ 用作登录账号       │   │            │
│        │            └────────────────────┘   │            │
│        │                                      │            │
│        │  密码      ┌────────────────────┐   │            │
│        │            │ 8-32 位，含字母+数字│   │            │
│        │            └────────────────────┘   │            │
│        │            [强度: 弱 中 强]（即时）  │            │
│        │                                      │            │
│        │  确认密码  ┌────────────────────┐   │            │
│        │            │ 再次输入密码       │   │            │
│        │            └────────────────────┘   │            │
│        │                                      │            │
│        │     ┌───────────────────────┐        │            │
│        │     │      创建并登录       │        │            │
│        │     └───────────────────────┘        │            │
│        │                                      │            │
│        └──────────────────────────────────────┘            │
│                                                            │
└────────────────────────────────────────────────────────────┘
```

实现要点：

- Antd `<Form>` + `<Form.Item rules>` 做客户端校验，规则与 5.2 后端 validator 对齐。
- 密码强度条：简单正则跑出 弱/中/强 三档作为软提示，不阻拦提交。
- "创建并登录"按钮：点击后 `loading`；接口成功后 `navigate("/login?email=<email>", { replace: true })`，**replace** 防止用户后退又回到向导。
- 失败处理：
  - 字段校验失败 → Antd Form 红字；
  - 后端 422 → errors 映射到对应 `Form.Item`；
  - 后端 409 → `message.warning("系统已被其他人完成初始化，请直接登录")` + `replace("/login")`；
  - 网络异常 → `message.error("网络异常，请重试")` + 解锁按钮。

### 6.4 登录页轻改（`pages/login/index.tsx`）

在 `useEffect` 中：

```ts
const [searchParams] = useSearchParams();
useEffect(() => {
  const presetEmail = searchParams.get("email");
  if (presetEmail) {
    setEmail(presetEmail);
    passwordRef.current?.focus();
  }
}, []);
```

邮箱预填，焦点直接落到密码框；不展示"刚刚完成初始化"的提示条 — 与"低调验证"的整体语气一致。

### 6.5 文案表

| Key | 中文 |
|---|---|
| setup.welcome.title | 欢迎使用 MeEdu |
| setup.welcome.subtitle | 请创建首位超级管理员账号 |
| setup.form.name | 姓名 |
| setup.form.email | 邮箱 |
| setup.form.password | 密码 |
| setup.form.password_confirmation | 确认密码 |
| setup.form.submit | 创建并登录 |
| setup.form.password_hint | 8-32 位，至少包含字母和数字 |
| setup.error.conflict | 系统已被其他人完成初始化，请直接登录 |

## 7. 边界场景

| # | 场景 | 行为 |
|---|---|---|
| 1 | install.lock 不存在但 admin 表已存在（老站升级） | `setup-status` 据 `Administrator::count()` 返回 `needs_init=false`，老站零打扰 |
| 2 | 两个浏览器同时打开向导并提交 | 后端事务内 `lockForUpdate` 复核 `exists()`，第一个成功，第二个 `abort(409)`；前端 409 转登录页 |
| 3 | 中途断网，事务回滚 | 表里仍无管理员，刷新页面重判 `needs_init=true`，用户重试 |
| 4 | 用户已登录后手动敲 `/setup` | 反向守卫强制跳走（已登录则回首页，未登录则回登录页） |
| 5 | 运维事后从命令行 `install administrator` 创建账号 | `setup-status` 即时反映 `needs_init=false`，向导不再展示 |
| 6 | 网络异常导致 `setup-status` 没拿到 | 启动门停在全屏 `<Spin />` + 5s timeout 后展示"系统状态获取失败，刷新重试"卡片，不退化到登录页 |
| 7 | install.php Step 2 改完但运维直接尝试默认账号登录 | 默认账号已不存在，登录页空跑无影响；启动门会引导去 `/setup` |
| 8 | 4.9.31 升级到本版本 | install.lock 已存在 + admin 表非空 → `needs_init=false`，零打扰 |

## 8. 测试计划

### 8.1 后端 PHPUnit（`xyz.meedu.api/tests`）

- `SystemSetupStatusTest`
  - admin 表为空 → 200 + `needs_init=true`
  - admin 表非空 → 200 + `needs_init=false`
- `SystemSetupTest`
  - 合法请求 → 200，admin 表新增 1 条，角色关联 super_slug，密码 Hash 存储
  - email 已存在 → 422
  - 密码不一致 → 422
  - 密码不符合复杂度 → 422
  - 已存在管理员时再调 → 409
  - 并发模拟（两个事务同时跑）→ 1 成功 1 失败 409

### 8.2 前端手测清单

- 全新部署：install → `/admin` → 自动跳 `/setup` → 填表 → 跳 `/login?email=xxx` → 邮箱已填、焦点在密码框 → 登录成功 → 进 `/edit-config`
- 已初始化系统：`/admin` → 直接登录页；手动敲 `/setup` → 立刻回 `/login`
- 后端 422 错误能映射到对应表单字段
- 后端 409 触发提示并跳登录页

## 9. 兼容与回滚

- **向后兼容**：数据库 schema 不动；现有命令 `install administrator` 不动；`config('meedu.administrator.super_slug')` 沿用；老站升级零打扰。
- **回滚路径**：
  1. install.php 改动是字符串模板级别，可逐版本回退；
  2. 新增的 setup 路由 / 控制器 / 前端页面是新增文件，回滚直接删除；
  3. install.php 里删去的 `install administrator -q` 这一行回滚时加回即可；
  4. 不引入任何 migration，无需 `migrate:rollback`。
- **灰度**：本功能只在"全新部署"路径上触发，不影响存量站点，随版本发布即可，无需 feature flag。

## 10. 文档配套

发布说明中加一段（版本号实施时按发布管线填）：

> 自 [发布版本] 起，初次安装完成后不再自动生成默认超级管理员账号（取消原 `meedu@meedu.meedu / meedu123` 默认账号）。请在浏览器中访问后台地址，按引导创建首位超级管理员。若部署在公网，建议在初始化完成前不要把后台地址外泄。
