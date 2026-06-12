<p align="center"><a href="https://www.sslbear.com?from=meedu">SSLBear - 云服务域名证书守护者|7x24小时监护让域名证书永不过期</a></p>

<h1 align="center">MeEdu - 数据安全的网校系统</h1>

<h4 align="center">
  <a href="https://www.meedu.vip">官网</a> |
  <a href="https://meedu.vip/price.html">商业版</a> |
  <a href="https://faq.meedu.vip">文档中心</a>
</h4>

<p align="center">⚡ 基于 PHP+Laravel 开发的在线网校解决方案 🔍</p>

**MeEdu** 是一款基于 PHP7.4 + Laravel8 + MySQL + Redis 开发的开源网校(知识付费)解决方案。支持线上点播、课程购买、网校装修、学员手机号登录注册、学习统计、角色管理等丰富功能。
**MeEdu** 是前后端分离的架构，支持 PC,H5 端口。此为 MeEdu 开源版本。**与此同时，我们还提供商业版本解决方案。商业版本支持直播课、考试练习、电子书、图文、站内问答、秒杀、团购、兑换码等更多功能；在开源的基础上还支持微信小程序、安卓 APP、苹果 APP 端口。**

## 🚀 快速上手

拉取代码：

```
git clone --branch main https://gitee.com/myteng/MeEdu.git meedu
```

运行(分 3 步):

**① 进入目录并复制环境配置**

```
cd meedu
cp .env.example .env          # Windows: 改为 copy .env.example .env
```

**② 编辑 `.env`,把 `APP_KEY=` 和 `JWT_SECRET=` 两行都填上随机密钥**

> `APP_KEY` 是 Laravel 全应用对称加密密钥(Cookie/Session/加密字段等);`JWT_SECRET` 是 JWT 签名密钥。两者**都必须自行生成且保密**,留空或使用公开示例值会导致 Cookie 可被解密、Token 可被伪造,出现未授权访问风险。

**生成 `APP_KEY`**(任选其一,必须是 `base64:<32 字节 base64>` 格式):

```
# macOS / Linux
echo "base64:$(openssl rand -base64 32)"

# Windows PowerShell
$b=New-Object byte[] 32;[Security.Cryptography.RandomNumberGenerator]::Create().GetBytes($b);"base64:"+[Convert]::ToBase64String($b)
```

**生成 `JWT_SECRET`**(任选其一):

```
# macOS / Linux
openssl rand -base64 48

# Windows PowerShell
$b=New-Object byte[] 48;[Security.Cryptography.RandomNumberGenerator]::Create().GetBytes($b);[Convert]::ToBase64String($b)
```

将输出分别粘贴到 `.env` 中对应行后面(等号后无空格),例如:

```
APP_KEY=base64:7tQp...(你生成的字符串)
JWT_SECRET=hVZ8b2pK...(你生成的字符串)
```

**③ 启动容器**

```
docker-compose up -d
```

等待 `30s` 左右。现在打开您的浏览器，输入 `http://localhost:8300` 即可访问后台管理界面。

- PC 端口 `http://localhost:8100`
- H5 端口 `http://localhost:8200`
- API 端口 `http://localhost:8000`

## 🔰️ 软件安全

安全问题应该通过邮件私下报告给 tengyongzhi@meedu.vip。 您将在 24 小时内收到回复，如果因为某些原因您没有收到回复，请通过回复原始邮件的方式跟进，以确保我们收到了您的原始邮件。

## 📃 使用许可

- 2026 © 杭州白书科技有限公司。
- 本软件遵循 Apache 2.0 许可证，附加特定的商业使用条件，使用此软件还需要遵循[附件条款和条件](ADDITIONAL_TERMS.md)。
