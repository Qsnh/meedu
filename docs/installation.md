
# 安装教程

### 环境要求

+ Composer
+ PHP >= 7.1
+ MySql >= 5.6
+ Xml PHP Extension
+ Zip PHP Extension
+ OpenSSL PHP Extension
+ PDO PHP Extension
+ Mbstring PHP Extension
+ Tokenizer PHP Extension
+ XML PHP Extension

### 可选（最好安装，否则影响部分功能使用）

+ mysql-dump工具（用户数据库备份）

### 步骤

#### 步骤一

安装 meedu

```
composer create-project qsnh/meedu=dev-master
```

> 因为 meedu 的正式稳定版本没有上线，因此在安装的时候我们总是选择最新的版本。

### 步骤二

配置数据库，打开 .env 文件，修改下面的内容：

```$xslt
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=homestead
DB_USERNAME=homestead
DB_PASSWORD=secret
```

配置基本信息

```$xslt
APP_NAME=MeEdu
APP_ENV=local(这里如果正式运行，请修改为：production)
APP_KEY=
APP_DEBUG=true(这里如果是正式运行，请修改为：false)
APP_LOG_LEVEL=debug
APP_URL=http://localhost(这里修改你自己的地址)
```

生成加密密钥：

```$xslt
php artisan key:generate
```

### 步骤三

创建上传目录软链接：

```$xslt
php artisan storage:link
```

### 步骤四

设置 `storage` 目录权限为 `777`

```$xslt
chomod -R  0777 storage
```

### 步骤五

配置伪静态并设置 meedu 的运行目录为 `public` 。

伪静态规则（Nginx）：

```$xslt
location / {  
	try_files $uri $uri/ /index.php$is_args$query_string;  
}
```

### 步骤六

安装数据表

```$xslt
php artisan migrate
```

### 步骤七

初始化管理员：

```$xslt
php artisan install administrator
```

安装提示输入管理员的账号和密码！

### 步骤八，结束

后台登陆地址：`http://youdomain.com/backend/login`
