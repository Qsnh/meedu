## MeEdu PC 界面程序

本项目使用 React18 + TypeScript + Ant.design 构建。

## 常用链接

- [MeEdu 官网](https://meedu.vip)
- [MeEdu 使用手册](https://www.yuque.com/meedu/fvvkbf)
- [MeEdu API 服务端程序代码](https://github.com/Qsnh/meedu)

## 快速上手

#### 一、安装依赖：

```
pnpm install
```

#### 二、修改配置：

```
cp .env.example .env.production
```

打开 `.env` 文件，修改其中的配置如下：

```
VITE_APP_URL=meedu的API服务地址
VITE_APP_GO_MEEDU_URL=go-meedu地址(如果你是开源用户则留空即可无需配置)
```

例如，我的 meedu 的 API 地址是 `https://demo-api.meedu.xyz` ，我的 go-meedu 的 API 地址是 `https://demo-go.meedu.xyz` 那么我的 `.env` 文件内容如下：

```
VITE_APP_URL=https://demo-api.meedu.xyz
VITE_APP_GO_MEEDU_URL=https://demo-go.meedu.xyz
```

#### 三、编译：

```
pnpm build
```

编译好，将会生成 `dist` 目录。将 `dist` 目录下的文件部署到新的站点。需要注意的是：

- 本项目默认开启了 gzip 压缩（可以提高访问速度、节省服务器流量）所以，建议您使用 nginx 部署。这里给出 nginx 开启 gzip 的配置：

```
gzip on;
gzip_min_length  1k;
gzip_buffers     4 16k;
gzip_http_version 1.1;
gzip_comp_level 2;
gzip_types     text/plain application/javascript application/x-javascript text/javascript text/css application/xml;
gzip_vary on;
gzip_proxied   expired no-cache no-store private auth;
gzip_disable   "MSIE [1-6]\.";
```

- 本项目的路由模式采用的是 history 模式，因此部署本项目需要配置伪静态规则，下面给出 nginx 的伪静态规则：

```
location / {
    try_files $uri $uri/ /index.html;
}
```
