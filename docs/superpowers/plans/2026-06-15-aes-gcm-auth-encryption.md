# AES-GCM-256 认证接口加密传输实现计划

> **For agentic workers:** REQUIRED SUB-SKILL: Use superpowers:subagent-driven-development (recommended) or superpowers:executing-plans to implement this plan task-by-task. Steps use checkbox (`- [ ]`) syntax for tracking.

**Goal:** 对注册、登录、密码重置等认证接口的整个请求体进行 AES-GCM-256 加密传输，防止链路明文抓包。

**Architecture:** 前端三端（PC/H5/Admin）在 Axios 请求拦截器中对白名单接口整体加密请求体，以 `{ payload: "<base64>" }` 形式发送；后端新增 `DecryptRequestPayload` 中间件在路由层解密并还原原始参数，Controller/Request 零改动。静态共享密钥存于各端 `.env`，硬切换不保留明文兼容。

**Tech Stack:** PHP 8 / Laravel / openssl_decrypt (aes-256-gcm)；TypeScript / React / Web Crypto API (浏览器原生，零额外依赖)；PHPUnit

---

## 文件清单

| 端 | 操作 | 路径 |
|---|---|---|
| 后端 | 新增 | `xyz.meedu.api/app/Http/Middleware/DecryptRequestPayload.php` |
| 后端 | 新增 | `xyz.meedu.api/tests/Unit/Middleware/DecryptRequestPayloadTest.php` |
| 后端 | 修改 | `xyz.meedu.api/config/meedu.php`（system 区块追加 `aes_encrypt_key`） |
| 后端 | 修改 | `xyz.meedu.api/app/Http/Kernel.php`（注册 `decrypt.payload` 别名） |
| 后端 | 修改 | `xyz.meedu.api/routes/frontend-v2.php`（4 条认证路由加中间件） |
| 后端 | 修改 | `xyz.meedu.api/routes/backend-v1.php`（2 条管理端路由加中间件） |
| 后端 | 修改 | `xyz.meedu.api/tests/Api/Frontend/V2/LoginTest.php` |
| 后端 | 修改 | `xyz.meedu.api/tests/Api/Frontend/V2/RegisterTest.php` |
| 后端 | 修改 | `xyz.meedu.api/tests/Api/Frontend/V2/PasswordTest.php` |
| 前端 PC | 新增 | `xyz.meedu.pc/src/utils/aesGcm.ts` |
| 前端 PC | 修改 | `xyz.meedu.pc/src/api/internal/httpClient.ts` |
| 前端 H5 | 新增 | `xyz.meedu.h5/src/utils/aesGcm.ts` |
| 前端 H5 | 修改 | `xyz.meedu.h5/src/api/internal/httpClient.ts` |
| 前端 Admin | 新增 | `xyz.meedu.admin/src/utils/aesGcm.ts` |
| 前端 Admin | 修改 | `xyz.meedu.admin/src/api/internal/httpClient.ts` |

---

## Task 1: 后端配置 — 添加 AES 密钥到 meedu.php

**Files:**
- Modify: `xyz.meedu.api/config/meedu.php:123`

- [ ] **Step 1: 在 `system` 区块末尾追加密钥配置**

找到 `config/meedu.php` 第 123 行的 `'system' => [` 区块，在该区块第一个键值对之前插入（紧接在 `'system' => [` 之后）：

```php
'system' => [
    'aes_encrypt_key' => env('AES_ENCRYPT_KEY', ''),
    // 网站名
    'name' => '',
    // ...其余已有配置不变
```

- [ ] **Step 2: 确认读取正确**

```bash
cd xyz.meedu.api
php artisan tinker --execute="echo config('meedu.system.aes_encrypt_key');"
```

期望输出：空字符串（`AES_ENCRYPT_KEY` 尚未设置）

- [ ] **Step 3: Commit**

```bash
git add xyz.meedu.api/config/meedu.php
git commit -m "feat: add AES_ENCRYPT_KEY config to meedu.system"
```

---

## Task 2: 后端中间件 — TDD 实现 DecryptRequestPayload

**Files:**
- Create: `xyz.meedu.api/tests/Unit/Middleware/DecryptRequestPayloadTest.php`
- Create: `xyz.meedu.api/app/Http/Middleware/DecryptRequestPayload.php`

- [ ] **Step 1: 创建测试文件（失败测试）**

新建 `xyz.meedu.api/tests/Unit/Middleware/DecryptRequestPayloadTest.php`：

```php
<?php

namespace Tests\Unit\Middleware;

use Tests\TestCase;
use Illuminate\Http\Request;
use App\Http\Middleware\DecryptRequestPayload;

class DecryptRequestPayloadTest extends TestCase
{
    private string $testKey = 'test-aes-key-must-be-32-bytes!!';

    private function encrypt(array $data): string
    {
        $iv = random_bytes(12);
        $tag = '';
        $ciphertext = openssl_encrypt(
            json_encode($data),
            'aes-256-gcm',
            $this->testKey,
            OPENSSL_RAW_DATA,
            $iv,
            $tag
        );
        return base64_encode($iv . $ciphertext . $tag);
    }

    public function test_missing_payload_returns_422()
    {
        $middleware = new DecryptRequestPayload();
        $request = Request::create('/test', 'POST', []);

        $response = $middleware->handle($request, fn($req) => response()->json(['ok' => true]));

        $this->assertEquals(422, $response->getStatusCode());
        $body = json_decode($response->getContent(), true);
        $this->assertEquals('请求数据异常', $body['message']);
    }

    public function test_invalid_base64_returns_422()
    {
        $middleware = new DecryptRequestPayload();
        $request = Request::create('/test', 'POST', ['payload' => '!!!not-base64!!!']);

        $response = $middleware->handle($request, fn($req) => response()->json(['ok' => true]));

        $this->assertEquals(422, $response->getStatusCode());
    }

    public function test_wrong_key_returns_422()
    {
        // encrypt with correct key, but config has wrong key
        $payload = $this->encrypt(['mobile' => '13800138000']);
        config(['meedu.system.aes_encrypt_key' => 'wrong-key-32-bytes-padding!!!!!']);

        $middleware = new DecryptRequestPayload();
        $request = Request::create('/test', 'POST', ['payload' => $payload]);

        $response = $middleware->handle($request, fn($req) => response()->json(['ok' => true]));

        $this->assertEquals(422, $response->getStatusCode());
    }

    public function test_valid_payload_merges_params_into_request()
    {
        $data = ['mobile' => '13800138000', 'password' => 'secret123'];
        $payload = $this->encrypt($data);
        config(['meedu.system.aes_encrypt_key' => $this->testKey]);

        $middleware = new DecryptRequestPayload();
        $request = Request::create('/test', 'POST', ['payload' => $payload]);

        $captured = null;
        $middleware->handle($request, function (Request $req) use (&$captured) {
            $captured = ['mobile' => $req->input('mobile'), 'password' => $req->input('password')];
            return response()->json(['ok' => true]);
        });

        $this->assertEquals('13800138000', $captured['mobile']);
        $this->assertEquals('secret123', $captured['password']);
    }

    public function test_too_short_raw_returns_422()
    {
        // 少于 28 字节（12 IV + 0 data + 16 tag = 28 最小）
        $payload = base64_encode(str_repeat('a', 10));
        config(['meedu.system.aes_encrypt_key' => $this->testKey]);

        $middleware = new DecryptRequestPayload();
        $request = Request::create('/test', 'POST', ['payload' => $payload]);

        $response = $middleware->handle($request, fn($req) => response()->json(['ok' => true]));

        $this->assertEquals(422, $response->getStatusCode());
    }
}
```

- [ ] **Step 2: 运行测试，确认失败（类不存在）**

```bash
cd xyz.meedu.api
vendor/bin/phpunit tests/Unit/Middleware/DecryptRequestPayloadTest.php --testdox
```

期望：FATAL — `Class 'App\Http\Middleware\DecryptRequestPayload' not found`

- [ ] **Step 3: 创建中间件**

新建 `xyz.meedu.api/app/Http/Middleware/DecryptRequestPayload.php`：

```php
<?php

/*
 * This file is part of the MeEdu.
 *
 * (c) 杭州白书科技有限公司
 */

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class DecryptRequestPayload
{
    public function handle(Request $request, Closure $next)
    {
        $payload = $request->input('payload');
        if (!$payload) {
            return response()->json(['code' => 422, 'message' => '请求数据异常'], 422);
        }

        $key = config('meedu.system.aes_encrypt_key');
        $raw = base64_decode($payload, true);
        if ($raw === false || strlen($raw) < 28) {
            return response()->json(['code' => 422, 'message' => '请求数据异常'], 422);
        }

        $iv         = substr($raw, 0, 12);
        $tag        = substr($raw, -16);
        $ciphertext = substr($raw, 12, -16);

        $plain = openssl_decrypt($ciphertext, 'aes-256-gcm', $key, OPENSSL_RAW_DATA, $iv, $tag);
        if ($plain === false) {
            return response()->json(['code' => 422, 'message' => '请求数据异常'], 422);
        }

        $data = json_decode($plain, true);
        if (!is_array($data)) {
            return response()->json(['code' => 422, 'message' => '请求数据异常'], 422);
        }

        $request->replace($data);
        return $next($request);
    }
}
```

- [ ] **Step 4: 运行测试，确认全部通过**

```bash
cd xyz.meedu.api
vendor/bin/phpunit tests/Unit/Middleware/DecryptRequestPayloadTest.php --testdox
```

期望：5 tests, 5 assertions — PASS

- [ ] **Step 5: Commit**

```bash
git add xyz.meedu.api/app/Http/Middleware/DecryptRequestPayload.php \
        xyz.meedu.api/tests/Unit/Middleware/DecryptRequestPayloadTest.php
git commit -m "feat: add DecryptRequestPayload middleware with tests"
```

---

## Task 3: 后端路由 — 注册中间件并绑定到认证路由

**Files:**
- Modify: `xyz.meedu.api/app/Http/Kernel.php`
- Modify: `xyz.meedu.api/routes/frontend-v2.php`
- Modify: `xyz.meedu.api/routes/backend-v1.php`

- [ ] **Step 1: 在 Kernel.php 注册中间件别名**

在 `app/Http/Kernel.php` 的 `$routeMiddleware` 数组末尾，紧接在 `'deprecated.api' => DeprecatedApiGuardMiddleware::class,` 之后追加：

```php
'decrypt.payload' => \App\Http\Middleware\DecryptRequestPayload::class,
```

- [ ] **Step 2: 更新 routes/frontend-v2.php — 将 4 条认证路由包入中间件分组**

找到以下 4 条独立路由（注意它们目前是独立行，不在任何 group 内）：

```php
// 手机短信注册
Route::post('/register/sms', 'RegisterController@smsHandler');
// 密码重置
Route::post('/password/reset', 'PasswordController@reset');
// 密码登录
Route::post('/login/password', 'LoginController@passwordLogin');
// 手机号登录
Route::post('/login/mobile', 'LoginController@mobileLogin');
```

将这 4 条路由替换为：

```php
// 认证接口 — 请求体经 AES-GCM-256 加密传输
Route::middleware('decrypt.payload')->group(function () {
    Route::post('/register/sms', 'RegisterController@smsHandler');
    Route::post('/password/reset', 'PasswordController@reset');
    Route::post('/login/password', 'LoginController@passwordLogin');
    Route::post('/login/mobile', 'LoginController@mobileLogin');
});
```

- [ ] **Step 3: 更新 routes/backend-v1.php — 将管理员登录和修改密码加入中间件**

找到当前公开路由区：
```php
// 公开路由
Route::post('/login', 'LoginController@login');
```
替换为：
```php
// 公开路由
Route::middleware('decrypt.payload')->post('/login', 'LoginController@login');
```

找到已有 `auth:administrator` 中间件组内的修改密码路由：
```php
Route::put('/administrator/password', 'AdministratorController@editPasswordHandle');
```
替换为：
```php
Route::middleware('decrypt.payload')->put('/administrator/password', 'AdministratorController@editPasswordHandle');
```

- [ ] **Step 4: Commit**

```bash
git add xyz.meedu.api/app/Http/Kernel.php \
        xyz.meedu.api/routes/frontend-v2.php \
        xyz.meedu.api/routes/backend-v1.php
git commit -m "feat: bind decrypt.payload middleware to auth routes"
```

---

## Task 4: 后端测试 — 更新现有认证测试使用加密请求

**Files:**
- Modify: `xyz.meedu.api/tests/Api/Frontend/V2/Base.php`
- Modify: `xyz.meedu.api/tests/Api/Frontend/V2/LoginTest.php`
- Modify: `xyz.meedu.api/tests/Api/Frontend/V2/RegisterTest.php`
- Modify: `xyz.meedu.api/tests/Api/Frontend/V2/PasswordTest.php`

> ⚠️ 路由已绑定中间件，现有测试（发明文）全部返回 422。需先添加加密辅助方法再更新各测试。

- [ ] **Step 1: 在 Base.php 添加加密辅助方法**

在 `tests/Api/Frontend/V2/Base.php` 中追加：

```php
protected string $aesTestKey = 'test-aes-key-must-be-32-bytes!!';

protected function encryptBody(array $data): array
{
    config(['meedu.system.aes_encrypt_key' => $this->aesTestKey]);
    $iv = random_bytes(12);
    $tag = '';
    $ciphertext = openssl_encrypt(
        json_encode($data),
        'aes-256-gcm',
        $this->aesTestKey,
        OPENSSL_RAW_DATA,
        $iv,
        $tag
    );
    return ['payload' => base64_encode($iv . $ciphertext . $tag)];
}
```

- [ ] **Step 2: 确认现有登录测试失败**

```bash
cd xyz.meedu.api
vendor/bin/phpunit tests/Api/Frontend/V2/LoginTest.php --testdox
```

期望：所有测试失败，原因是返回 422（中间件拒绝明文）

- [ ] **Step 3: 更新 LoginTest.php**

将 `tests/Api/Frontend/V2/LoginTest.php` 中所有 `postJson` 调用替换为先用 `encryptBody` 加密：

```php
<?php

namespace Tests\Api\Frontend\V2;

use App\Constant\CacheConstant;
use App\Services\Member\Models\User;
use Illuminate\Support\Facades\Hash;
use App\Services\Base\Services\CacheService;
use App\Services\Base\Interfaces\CacheServiceInterface;
use Illuminate\Support\Str;

class LoginTest extends Base
{
    public function test_with_correct_password()
    {
        $user = User::factory()->create([
            'mobile' => '13890900909',
            'is_lock' => User::LOCK_NO,
        ]);
        $response = $this->postJson('/api/v2/login/password', $this->encryptBody([
            'mobile' => $user->mobile,
            'password' => '123456',
        ]));
        $this->assertResponseSuccess($response);
    }

    public function test_with_locked()
    {
        $user = User::factory()->create([
            'mobile' => '13890900909',
            'password' => Hash::make('123123'),
            'is_lock' => User::LOCK_YES,
        ]);
        $response = $this->postJson('/api/v2/login/password', $this->encryptBody([
            'mobile' => $user->mobile,
            'password' => '123123',
        ]));
        $this->assertResponseError($response, __('账号已被锁定'));
    }

    public function test_with_error_password()
    {
        $user = User::factory()->create([
            'mobile' => '13890900909',
            'is_lock' => User::LOCK_NO,
        ]);
        $response = $this->postJson('/api/v2/login/password', $this->encryptBody([
            'mobile' => $user->mobile,
            'password' => 'asd12312',
        ]));
        $this->assertResponseError($response, __('手机号或密码错误'));
    }

    public function test_mobile_login()
    {
        $mobile = '13890900909';
        $mobileCode = Str::random(6);

        /** @var CacheService $cacheService */
        $cacheService = app()->make(CacheServiceInterface::class);
        $key = get_cache_key(CacheConstant::MOBILE_CODE['name'], $mobile);
        $cacheService->put($key, $mobileCode, 100);

        $response = $this->postJson('/api/v2/login/mobile', $this->encryptBody([
            'mobile' => $mobile,
            'mobile_code' => $mobileCode,
        ]));
        $this->assertResponseSuccess($response);
    }
}
```

- [ ] **Step 4: 更新 RegisterTest.php**

将 `tests/Api/Frontend/V2/RegisterTest.php` 中的 `postJson` 调用改为使用 `encryptBody`：

```php
<?php

namespace Tests\Api\Frontend\V2;

use Illuminate\Support\Str;
use App\Constant\CacheConstant;
use App\Services\Member\Models\User;
use Illuminate\Support\Facades\Hash;
use App\Services\Base\Services\CacheService;
use App\Services\Base\Interfaces\CacheServiceInterface;

class RegisterTest extends Base
{
    public function test_register_ok()
    {
        $mobile = '18287829922';
        $password = Str::random(12);
        $mobileCode = Str::random(6);

        /** @var CacheService $cacheService */
        $cacheService = app()->make(CacheServiceInterface::class);
        $key = get_cache_key(CacheConstant::MOBILE_CODE['name'], $mobile);
        $cacheService->put($key, $mobileCode, 100);

        $response = $this->postJson('/api/v2/register/sms', $this->encryptBody([
            'mobile' => $mobile,
            'mobile_code' => $mobileCode,
            'password' => $password,
        ]));
        $this->assertResponseSuccess($response);

        $user = User::query()->where('mobile', $mobile)->first();
        $this->assertNotEmpty($user);
        $this->assertTrue(Hash::check($password, $user->password));
        $this->assertEquals(0, $user->is_set_nickname);
        $this->assertEquals(1, $user->is_password_set);
    }

    public function test_exists_mobile()
    {
        $mobile = '18287829922';
        $password = Str::random(12);
        $mobileCode = Str::random(6);

        User::factory()->create(['mobile' => $mobile]);

        /** @var CacheService $cacheService */
        $cacheService = app()->make(CacheServiceInterface::class);
        $key = get_cache_key(CacheConstant::MOBILE_CODE['name'], $mobile);
        $cacheService->put($key, $mobileCode, 100);

        $response = $this->postJson('/api/v2/register/sms', $this->encryptBody([
            'mobile' => $mobile,
            'mobile_code' => $mobileCode,
            'password' => $password,
        ]));
        $this->assertResponseError($response, __('手机号已存在'));
    }
}
```

- [ ] **Step 5: 更新 PasswordTest.php**

将 `tests/Api/Frontend/V2/PasswordTest.php` 中的 `postJson` 调用改为使用 `encryptBody`：

```php
<?php

namespace Tests\Api\Frontend\V2;

use Illuminate\Support\Str;
use App\Constant\CacheConstant;
use App\Services\Member\Models\User;
use Illuminate\Support\Facades\Hash;
use App\Services\Base\Services\CacheService;
use App\Services\Base\Interfaces\CacheServiceInterface;

class PasswordTest extends Base
{
    public function test()
    {
        $mobile = '18287829922';
        $oldPassword = '123123';
        $newPassword = '456456';
        $user = User::factory()->create(['mobile' => $mobile, 'password' => Hash::make($oldPassword)]);

        $mobileCode = Str::random(6);

        /** @var CacheService $cacheService */
        $cacheService = app()->make(CacheServiceInterface::class);
        $key = get_cache_key(CacheConstant::MOBILE_CODE['name'], $mobile);
        $cacheService->put($key, $mobileCode, 100);

        $response = $this->postJson('/api/v2/password/reset', $this->encryptBody([
            'mobile' => $mobile,
            'mobile_code' => $mobileCode,
            'password' => $newPassword,
        ]));
        $this->assertResponseSuccess($response);

        $user->refresh();
        $this->assertTrue(Hash::check($newPassword, $user->password));
    }

    public function test_sms_error()
    {
        $mobile = '18287829922';
        $newPassword = '456456';
        User::factory()->create(['mobile' => $mobile]);

        $response = $this->postJson('/api/v2/password/reset', $this->encryptBody([
            'mobile' => $mobile,
            'mobile_code' => 'wrongcode',
            'password' => $newPassword,
        ]));
        $this->assertResponseError($response, __('短信验证码错误'));
    }

    public function test_mobile_not_exists()
    {
        $mobile = '18287829922';
        $mobileCode = Str::random(6);
        $newPassword = '456456';

        /** @var CacheService $cacheService */
        $cacheService = app()->make(CacheServiceInterface::class);
        $key = get_cache_key(CacheConstant::MOBILE_CODE['name'], $mobile);
        $cacheService->put($key, $mobileCode, 100);

        $response = $this->postJson('/api/v2/password/reset', $this->encryptBody([
            'mobile' => $mobile,
            'mobile_code' => $mobileCode,
            'password' => $newPassword,
        ]));
        $this->assertResponseError($response, __('手机号不存在'));
    }
}
```

- [ ] **Step 6: 运行所有受影响的测试**

```bash
cd xyz.meedu.api
vendor/bin/phpunit tests/Api/Frontend/V2/LoginTest.php tests/Api/Frontend/V2/RegisterTest.php tests/Api/Frontend/V2/PasswordTest.php --testdox
```

期望：所有测试 PASS

- [ ] **Step 7: 运行完整测试套件，确认无回归**

```bash
cd xyz.meedu.api
vendor/bin/phpunit --testdox
```

期望：全部 PASS（注意 LoginTest 中的 `test_mobile_login` 依赖短信验证码缓存，确认通过）

- [ ] **Step 8: Commit**

```bash
git add xyz.meedu.api/tests/Api/Frontend/V2/Base.php \
        xyz.meedu.api/tests/Api/Frontend/V2/LoginTest.php \
        xyz.meedu.api/tests/Api/Frontend/V2/RegisterTest.php \
        xyz.meedu.api/tests/Api/Frontend/V2/PasswordTest.php
git commit -m "test: update auth tests to send AES-GCM-256 encrypted requests"
```

---

## Task 5: 前端 PC — 加密工具 + 拦截器

**Files:**
- Create: `xyz.meedu.pc/src/utils/aesGcm.ts`
- Modify: `xyz.meedu.pc/src/api/internal/httpClient.ts`

- [ ] **Step 1: 创建 `src/utils/aesGcm.ts`**

```typescript
const RAW_KEY = import.meta.env.VITE_AES_KEY as string;

let _cachedKey: CryptoKey | null = null;

async function getKey(): Promise<CryptoKey> {
  if (_cachedKey) return _cachedKey;
  const raw = new TextEncoder().encode(RAW_KEY);
  _cachedKey = await crypto.subtle.importKey('raw', raw, 'AES-GCM', false, ['encrypt']);
  return _cachedKey;
}

export async function encryptPayload(body: object): Promise<string> {
  const key = await getKey();
  const iv = crypto.getRandomValues(new Uint8Array(12));
  const plaintext = new TextEncoder().encode(JSON.stringify(body));
  // Web Crypto API AES-GCM 输出 = ciphertext + AuthTag(16B) 已拼接
  const cipherBuf = await crypto.subtle.encrypt({ name: 'AES-GCM', iv }, key, plaintext);
  const combined = new Uint8Array(12 + cipherBuf.byteLength);
  combined.set(iv, 0);
  combined.set(new Uint8Array(cipherBuf), 12);
  let binary = '';
  combined.forEach((b) => { binary += String.fromCharCode(b); });
  return btoa(binary);
}
```

- [ ] **Step 2: 修改 `src/api/internal/httpClient.ts`**

在文件顶部追加 import（紧接现有 import 之后）：

```typescript
import { encryptPayload } from '../../utils/aesGcm';
```

在 `HttpClient` 类的 constructor 中，找到已有的 `this.axios.interceptors.request.use(` 块，将其替换为以下 async 版本：

```typescript
const ENCRYPTED_PATHS = new Set([
  '/api/v2/login/password',
  '/api/v2/login/mobile',
  '/api/v2/register/sms',
  '/api/v2/password/reset',
]);

this.axios.interceptors.request.use(
  async (config) => {
    const token = getToken();
    token && (config.headers.Authorization = 'Bearer ' + token);

    const url = config.url ?? '';
    if (config.method === 'post' && ENCRYPTED_PATHS.has(url) && config.data) {
      const encrypted = await encryptPayload(config.data);
      config.data = { payload: encrypted };
    }

    return config;
  },
  (err) => {
    return Promise.reject(err);
  }
);
```

注意：`ENCRYPTED_PATHS` 常量定义在 constructor 内、`interceptors.request.use` 之前。

- [ ] **Step 3: 验证 TypeScript 编译无错误**

```bash
cd xyz.meedu.pc
pnpm tsc --noEmit
```

期望：无错误输出

- [ ] **Step 4: Commit**

```bash
git add xyz.meedu.pc/src/utils/aesGcm.ts xyz.meedu.pc/src/api/internal/httpClient.ts
git commit -m "feat(pc): add AES-GCM-256 encryption to auth request interceptor"
```

---

## Task 6: 前端 H5 — 加密工具 + 拦截器

**Files:**
- Create: `xyz.meedu.h5/src/utils/aesGcm.ts`
- Modify: `xyz.meedu.h5/src/api/internal/httpClient.ts`

- [ ] **Step 1: 创建 `src/utils/aesGcm.ts`（与 PC 相同内容）**

```typescript
const RAW_KEY = import.meta.env.VITE_AES_KEY as string;

let _cachedKey: CryptoKey | null = null;

async function getKey(): Promise<CryptoKey> {
  if (_cachedKey) return _cachedKey;
  const raw = new TextEncoder().encode(RAW_KEY);
  _cachedKey = await crypto.subtle.importKey('raw', raw, 'AES-GCM', false, ['encrypt']);
  return _cachedKey;
}

export async function encryptPayload(body: object): Promise<string> {
  const key = await getKey();
  const iv = crypto.getRandomValues(new Uint8Array(12));
  const plaintext = new TextEncoder().encode(JSON.stringify(body));
  const cipherBuf = await crypto.subtle.encrypt({ name: 'AES-GCM', iv }, key, plaintext);
  const combined = new Uint8Array(12 + cipherBuf.byteLength);
  combined.set(iv, 0);
  combined.set(new Uint8Array(cipherBuf), 12);
  let binary = '';
  combined.forEach((b) => { binary += String.fromCharCode(b); });
  return btoa(binary);
}
```

- [ ] **Step 2: 修改 `src/api/internal/httpClient.ts`**

在文件顶部追加 import：

```typescript
import { encryptPayload } from '../../utils/aesGcm';
```

在 `HttpClient` constructor 中，将已有的 `this.axios.interceptors.request.use(` 块替换为：

```typescript
const ENCRYPTED_PATHS = new Set([
  '/api/v2/login/password',
  '/api/v2/login/mobile',
  '/api/v2/register/sms',
  '/api/v2/password/reset',
]);

this.axios.interceptors.request.use(
  async (config) => {
    const token = getToken();
    token && (config.headers.Authorization = 'Bearer ' + token);

    const url = config.url ?? '';
    if (config.method === 'post' && ENCRYPTED_PATHS.has(url) && config.data) {
      const encrypted = await encryptPayload(config.data);
      config.data = { payload: encrypted };
    }

    return config;
  },
  (err) => {
    return Promise.reject(err);
  }
);
```

- [ ] **Step 3: 验证 TypeScript 编译无错误**

```bash
cd xyz.meedu.h5
pnpm tsc --noEmit
```

期望：无错误输出

- [ ] **Step 4: Commit**

```bash
git add xyz.meedu.h5/src/utils/aesGcm.ts xyz.meedu.h5/src/api/internal/httpClient.ts
git commit -m "feat(h5): add AES-GCM-256 encryption to auth request interceptor"
```

---

## Task 7: 前端 Admin — 加密工具 + 拦截器

**Files:**
- Create: `xyz.meedu.admin/src/utils/aesGcm.ts`
- Modify: `xyz.meedu.admin/src/api/internal/httpClient.ts`

- [ ] **Step 1: 创建 `src/utils/aesGcm.ts`**

```typescript
const RAW_KEY = import.meta.env.VITE_AES_KEY as string;

let _cachedKey: CryptoKey | null = null;

async function getKey(): Promise<CryptoKey> {
  if (_cachedKey) return _cachedKey;
  const raw = new TextEncoder().encode(RAW_KEY);
  _cachedKey = await crypto.subtle.importKey('raw', raw, 'AES-GCM', false, ['encrypt']);
  return _cachedKey;
}

export async function encryptPayload(body: object): Promise<string> {
  const key = await getKey();
  const iv = crypto.getRandomValues(new Uint8Array(12));
  const plaintext = new TextEncoder().encode(JSON.stringify(body));
  const cipherBuf = await crypto.subtle.encrypt({ name: 'AES-GCM', iv }, key, plaintext);
  const combined = new Uint8Array(12 + cipherBuf.byteLength);
  combined.set(iv, 0);
  combined.set(new Uint8Array(cipherBuf), 12);
  let binary = '';
  combined.forEach((b) => { binary += String.fromCharCode(b); });
  return btoa(binary);
}
```

- [ ] **Step 2: 修改 `src/api/internal/httpClient.ts`**

在文件顶部追加 import：

```typescript
import { encryptPayload } from '../../utils/aesGcm';
```

在 `HttpClient` constructor 中，将已有的 `this.axios.interceptors.request.use(` 块替换为（注意 Admin 还需处理 `put` 方法）：

```typescript
const ENCRYPTED_PATHS = new Set([
  '/backend/api/v1/login',
  '/backend/api/v1/administrator/password',
]);

this.axios.interceptors.request.use(
  async (config) => {
    const token = getToken();
    token && (config.headers.Authorization = 'Bearer ' + token);

    const url = config.url ?? '';
    const method = config.method ?? '';
    if (['post', 'put'].includes(method) && ENCRYPTED_PATHS.has(url) && config.data) {
      const encrypted = await encryptPayload(config.data);
      config.data = { payload: encrypted };
    }

    return config;
  },
  (err) => {
    return Promise.reject(err);
  }
);
```

- [ ] **Step 3: 验证 TypeScript 编译无错误**

```bash
cd xyz.meedu.admin
pnpm tsc --noEmit
```

期望：无错误输出

- [ ] **Step 4: Commit**

```bash
git add xyz.meedu.admin/src/utils/aesGcm.ts xyz.meedu.admin/src/api/internal/httpClient.ts
git commit -m "feat(admin): add AES-GCM-256 encryption to auth request interceptor"
```

---

## Task 8: 环境配置 & 手动冒烟测试

**Files:**
- Modify: `xyz.meedu.api/.env`
- Modify: `xyz.meedu.pc/.env`（或 `.env.local`）
- Modify: `xyz.meedu.h5/.env`（或 `.env.local`）
- Modify: `xyz.meedu.admin/.env`（或 `.env.local`）

- [ ] **Step 1: 生成 32 字节随机密钥**

```bash
openssl rand -base64 24 | head -c 32
```

记录输出（示例：`mK9xQpL2nR7vF4jY8wC5eA3hG6bN1dT0`）

- [ ] **Step 2: 写入各端 .env**

**`xyz.meedu.api/.env`**（追加）：
```
AES_ENCRYPT_KEY=<上面生成的32字节密钥>
```

**`xyz.meedu.pc/.env.local`**（或 `.env`，追加）：
```
VITE_AES_KEY=<同一密钥>
```

**`xyz.meedu.h5/.env.local`**（追加）：
```
VITE_AES_KEY=<同一密钥>
```

**`xyz.meedu.admin/.env.local`**（追加）：
```
VITE_AES_KEY=<同一密钥>
```

- [ ] **Step 3: 重启后端 + 重建前端**

```bash
# 后端（清除配置缓存）
cd xyz.meedu.api && php artisan config:clear

# 前端（在各自目录）
cd xyz.meedu.pc && pnpm dev
cd xyz.meedu.h5 && pnpm dev
cd xyz.meedu.admin && pnpm dev
```

- [ ] **Step 4: PC 端冒烟测试**

打开 PC 前端，打开 Chrome DevTools → Network

1. 访问登录弹窗，用密码登录：观察 `/api/v2/login/password` 请求的 Request Payload，应为 `{ "payload": "<base64字符串>" }`（而非明文 mobile/password）
2. 登录成功后返回 token，页面正常
3. 访问注册页面，注册一个新账号：观察 `/api/v2/register/sms` 请求 Payload 同样为加密格式
4. 访问忘记密码页面：观察 `/api/v2/password/reset` 请求同样加密

- [ ] **Step 5: Admin 端冒烟测试**

打开 Admin 前端，打开 Network 面板

1. 执行管理员登录：观察 `/backend/api/v1/login` 请求 Payload 为 `{ "payload": "<base64>" }`
2. 登录成功后进入后台
3. 访问个人信息 → 修改密码：观察 `/backend/api/v1/administrator/password` 请求同样加密

- [ ] **Step 6: 验证非加密接口不受影响**

在 Network 中确认以下接口依然发送明文（未加密）：
- `GET /api/v2/courses`
- `POST /api/v2/captcha/sms`

---

## 自检核对

| 需求 | 对应 Task |
|---|---|
| 密码登录加密 | Task 3 (路由) + Task 4 (测试) + Task 5/6 (前端) |
| 短信登录加密 | 同上 |
| 注册加密 | 同上 |
| 密码重置加密 | 同上 |
| Admin 登录加密 | Task 3 (路由) + Task 7 (前端) |
| Admin 修改密码加密 | 同上 |
| 静态密钥从 .env 读取 | Task 1 (后端) + Task 8 (环境) |
| 解密失败返回 422 | Task 2 (中间件测试覆盖) |
| Controller/Request 零改动 | 中间件 `$request->replace()` |
| 硬切换 | 中间件无明文兼容分支 |
