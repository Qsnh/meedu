## MeEdu API 程序

本程序使用 PHP7.4 + Laravel8 + MySQL + Redis + Meilisearch 开发。

## 快速上手

### 环境要求

- Linux 系统(centos,ubuntu等)
- PHP7.4
- MySQL 5.6+
- Redis 5.0+
- Meilisearch 0.24.0
- Composer 2.x

### PHP 扩展

- Zip PHP Extension
- OpenSSL PHP Extension
- PDOMysql PHP Extension
- Mbstring PHP Extension
- Tokenizer PHP Extension
- XML PHP Extension
- Fileinfo PHP Extension

### PHP 函数解除禁用

- `passthru`
- `proc_open`
- `proc_get_status`
- `symlink`
- `putenv`

### 开始安装

> 假设您已经下载本程序代码，并进入到了 API 程序目录。

- 安装程序依赖：  

```
composer install --no-dev
```

- 复制配置文件：  

```
cp .env.example .env
```

打开 `.env` 配置文件，并修改其中的 MySQL 和 Redis 的连接信息。配置项如下：

```
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=meedu
DB_USERNAME=root
DB_PASSWORD=root

REDIS_HOST=127.0.0.1
REDIS_PASSWORD=null
REDIS_PORT=6379
```

> 注意，上述是我的本地配置，您需要根据您的环境配置修改。

- 生成系统秘钥：

```
php artisan key:generate
php artisan jwt:secret
```

- 目录权限问题：

请注意 `API` 程序的文件和目录权限所属用户和用户组与 `Nginx` 运行用户和用户组一致（一般是 `www` 或者 `www-data`）。如果不一致的话，那么您需要手动授权下下面目录的权限：

```
chmod -R 0777 storage
chmod -R 0777 addons
```

- 创建静态资源软链接：

```
php artisan storage:link
```

- 配置 Nginx 伪静态，规则如下：

```
location / {  
	try_files $uri $uri/ /index.php$is_args$query_string;  
}
```

- 安装数据库表和默认数据：

```
php artisan migrate
php artisan install role
php artisan install config
php artisan install administrator
```

- 生成安装锁文件：

```
php artisan install:lock
```

- 定时任务配置：

将下面的命令添加到 `crontab` 中：

```
* * * * * php /你的meedu api程序所在目录/artisan schedule:run >> /dev/null 2>&1
```