# AES-GCM-256 认证接口加密传输设计

**日期**：2026-06-15  
**状态**：已批准，待实现

---

## 背景

注册、登录、密码重置找回等认证接口中，手机号和密码目前以明文 JSON 在 HTTP Body 中传输，存在链路抓包泄露风险。需要通过 AES-GCM-256 整体加密请求体来保护传输安全。

---

## 需求

- 对认证相关接口的**整个请求体**进行 AES-GCM-256 加密后传输
- 静态共享密钥，前后端各自配置到 `.env`
- 硬切换，不保留明文兼容
- 涉及端：前端 PC、前端 H5、前端 Admin，后端 Laravel API

---

## 涉及接口

### 前端 PC + H5

| 接口 | 方法 | 说明 |
|---|---|---|
| `/api/v2/login/password` | POST | 密码登录（mobile + password） |
| `/api/v2/login/mobile` | POST | 短信登录（mobile） |
| `/api/v2/register/sms` | POST | 短信注册（mobile + password） |
| `/api/v2/password/reset` | POST | 密码重置（mobile + password） |

### 前端 Admin

| 接口 | 方法 | 说明 |
|---|---|---|
| `/backend/api/v1/login` | POST | 管理员登录（username + password） |
| `/backend/api/v1/administrator/password` | PUT | 管理员修改密码 |

---

## 整体架构

```
┌─────────────────────────────────────────────────────────┐
│  前端（PC / H5 / Admin — 各自 httpClient.ts）            │
│                                                         │
│  Axios 请求拦截器                                         │
│  ├─ 判断当前请求 URL 是否在加密白名单中                     │
│  ├─ 命中 → 用 Web Crypto API (AES-GCM-256) 加密原始 body │
│  │         原始 body → { "payload": "<base64>" }        │
│  └─ 未命中 → 正常透传                                     │
└───────────────────────┬─────────────────────────────────┘
                        │ HTTPS
                        ▼
┌─────────────────────────────────────────────────────────┐
│  后端（Laravel — xyz.meedu.api）                          │
│                                                         │
│  DecryptRequestPayload 中间件（新增）                      │
│  ├─ 发现 payload 字段 → base64 解码 → openssl 解密         │
│  ├─ 解密失败 → 返回 422                                   │
│  └─ 解密成功 → 将参数 merge 回 $request，继续正常流程      │
│                                                         │
│  Controller / Request 完全不感知加密（零改动）             │
└─────────────────────────────────────────────────────────┘
```

---

## 密钥管理

| 端 | 环境变量 | 说明 |
|---|---|---|
| 后端 | `AES_ENCRYPT_KEY=<32字节密钥>` | `config/meedu.php` 读取 |
| 前端 PC | `VITE_AES_KEY=<同一密钥>` | Vite 编译时注入 |
| 前端 H5 | `VITE_AES_KEY=<同一密钥>` | Vite 编译时注入 |
| 前端 Admin | `VITE_AES_KEY=<同一密钥>` | Vite 编译时注入 |

**密钥生成**：`openssl rand -base64 24 | head -c 32`（32 字节随机字符串）

> ⚠️ 前端密钥会编译进 JS 产物中，这是静态共享密钥方案的固有局限。主要防护目标是传输链路明文抓包，非对抗前端逆向。

---

## 加密格式

```
原始 body（JSON 字符串）
        │
        │ AES-GCM-256 加密
        │  - IV：每次请求随机生成 12 字节
        │  - Auth Tag：16 字节（Web Crypto API / OpenSSL 默认追加在密文末尾）
        ▼
二进制拼接：[ IV(12B) | Ciphertext | AuthTag(16B) ]
        │
        │ Base64 编码
        ▼
HTTP Body：{ "payload": "base64string..." }
```

---

## 实现细节

### 涉及文件清单

| 端 | 新增 | 改动 |
|---|---|---|
| 后端 API | `app/Http/Middleware/DecryptRequestPayload.php` | `routes/frontend-v2.php`、`routes/backend-v1.php`、`app/Http/Kernel.php`、`config/meedu.php` |
| 前端 PC | `src/utils/aesGcm.ts` | `src/api/internal/httpClient.ts` |
| 前端 H5 | `src/utils/aesGcm.ts` | `src/api/internal/httpClient.ts` |
| 前端 Admin | `src/utils/aesGcm.ts` | `src/api/internal/httpClient.ts` |

---

### 后端：`DecryptRequestPayload` 中间件

**文件**：`app/Http/Middleware/DecryptRequestPayload.php`

```php
<?php

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

### 后端：路由绑定

**`routes/frontend-v2.php`**（在现有路由上追加中间件分组）：
```php
Route::middleware('decrypt.payload')->group(function () {
    Route::post('/login/password', 'LoginController@passwordLogin');
    Route::post('/login/mobile',   'LoginController@mobileLogin');
    Route::post('/register/sms',   'RegisterController@smsHandler');
    Route::post('/password/reset', 'PasswordController@reset');
});
```

**`routes/backend-v1.php`**：
```php
// 登录接口
Route::middleware('decrypt.payload')->group(function () {
    Route::post('/login', 'LoginController@login');
});

// 修改密码（在已有 auth 中间件组内）
Route::middleware(['auth.backend', 'decrypt.payload'])
     ->put('/administrator/password', 'AdministratorController@editPasswordHandle');
```

**`app/Http/Kernel.php`** — 注册别名：
```php
protected $routeMiddleware = [
    // ... 已有 ...
    'decrypt.payload' => \App\Http\Middleware\DecryptRequestPayload::class,
];
```

**`config/meedu.php`** — 新增配置项：
```php
'system' => [
    // ... 已有 ...
    'aes_encrypt_key' => env('AES_ENCRYPT_KEY', ''),
],
```

---

### 前端：共用加密工具

**文件**：`src/utils/aesGcm.ts`（PC、H5、Admin 各自创建）

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
  // Web Crypto API 的 AES-GCM 输出已包含 AuthTag（追加在密文末尾）
  const cipherBuf = await crypto.subtle.encrypt({ name: 'AES-GCM', iv }, key, plaintext);
  const combined = new Uint8Array(12 + cipherBuf.byteLength);
  combined.set(iv, 0);
  combined.set(new Uint8Array(cipherBuf), 12);
  return btoa(String.fromCharCode(...combined));
}
```

### 前端 PC + H5：`httpClient.ts` 改动

```typescript
import { encryptPayload } from '../utils/aesGcm';

const ENCRYPTED_PATHS = new Set([
  '/api/v2/login/password',
  '/api/v2/login/mobile',
  '/api/v2/register/sms',
  '/api/v2/password/reset',
]);

// 在已有 request interceptor 中追加：
this.axios.interceptors.request.use(async (config) => {
  const token = getToken();
  token && (config.headers.Authorization = 'Bearer ' + token);

  const url = config.url ?? '';
  if (config.method === 'post' && ENCRYPTED_PATHS.has(url) && config.data) {
    const encrypted = await encryptPayload(config.data);
    config.data = { payload: encrypted };
  }

  return config;
});
```

### 前端 Admin：`httpClient.ts` 改动

```typescript
import { encryptPayload } from '../utils/aesGcm';

const ENCRYPTED_PATHS = new Set([
  '/backend/api/v1/login',
  '/backend/api/v1/administrator/password',
]);

// PUT 方法也需要加密（修改密码接口）
this.axios.interceptors.request.use(async (config) => {
  const token = getToken();
  token && (config.headers.Authorization = 'Bearer ' + token);

  const url = config.url ?? '';
  if (['post', 'put'].includes(config.method ?? '') && ENCRYPTED_PATHS.has(url) && config.data) {
    const encrypted = await encryptPayload(config.data);
    config.data = { payload: encrypted };
  }

  return config;
});
```

---

## 错误处理

| 场景 | 后端行为 | 前端感知 |
|---|---|---|
| `payload` 字段缺失 | 422 `请求数据异常` | Axios catch → 现有错误弹窗 |
| base64 格式非法 | 422 `请求数据异常` | 同上 |
| 解密失败（密钥不匹配 / 数据篡改） | 422 `请求数据异常` | 同上 |
| JSON 解析失败 | 422 `请求数据异常` | 同上 |
| `VITE_AES_KEY` 未配置 | 后端解密必然失败 | 422 |
| `AES_ENCRYPT_KEY` 未配置 | openssl 使用空字符串 key 解密失败 | 422 |

所有错误统一返回 422，不暴露具体原因，避免信息泄露。

---

## 部署注意事项

1. **密钥生成**：`openssl rand -base64 24 | head -c 32`，四个 `.env` 填同一个值
2. **HTTPS 必须**：AES-GCM 防链路明文抓包，必须配合 HTTPS
3. **三端同步上线**：硬切换，后端部署后旧版前端立即失效，PC / H5 / Admin 与后端需同一批次发布
4. **浏览器兼容**：Web Crypto API 原生支持，无需额外 npm 包（Chrome 37+、Firefox 34+、Safari 11+）
5. **密钥轮换**：需前后端同时部署，建议在运维文档中记录轮换流程
