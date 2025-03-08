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

运行：

```
cd meedu && cp .env.example .env && docker-compose up -d
```

> 🚨请注意，上述命令运行 MeEdu 存在一定的使用安全风险，仅供测试使用！如需在正式生产环境使用 MeEdu 还请阅读 [部署文档](https://faq.meedu.vip/doc/g9jK0KXmFe) 。

等待 `30s` 左右。现在打开您的浏览器，输入 `http://localhost:8300` 即可访问后台管理界面，默认管理员账号和密码 `meedu@meedu.meedu / meedu123` 。

- PC 端口 `http://localhost:8100`
- H5 端口 `http://localhost:8200`
- API 端口 `http://localhost:8000`

## 🔰️ 软件安全

安全问题应该通过邮件私下报告给 tengyongzhi@meedu.vip。 您将在 24 小时内收到回复，如果因为某些原因您没有收到回复，请通过回复原始邮件的方式跟进，以确保我们收到了您的原始邮件。

## 📃 使用许可

- 2024 © 杭州白书科技有限公司。
- 本软件遵循 Apache 2.0 许可证，附加特定的商业使用条件，使用此软件还需要遵循[附件条款和条件](ADDITIONAL_TERMS.md)。
