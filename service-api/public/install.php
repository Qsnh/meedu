<?php

function alert($message)
{
    header('Content-type: text/html; charset="UTF-8"');
    exit($message);
}

function is_https()
{
    if (!empty($_SERVER['HTTPS']) && strtolower($_SERVER['HTTPS']) !== 'off') {
        return true;
    } elseif (isset($_SERVER['HTTP_X_FORWARDED_PROTO']) && $_SERVER['HTTP_X_FORWARDED_PROTO'] === 'https') {
        return true;
    } elseif (!empty($_SERVER['HTTP_FRONT_END_HTTPS']) && strtolower($_SERVER['HTTP_FRONT_END_HTTPS']) !== 'off') {
        return true;
    }
    return false;
}

if (file_exists('../storage/install.lock')) {
    alert('请勿重复安装');
}
$uri = $_SERVER['REQUEST_URI'];
if (mb_substr($uri, 0, 7) === '/public') {
    // 网站根目录配置错啦
    alert('网站运行根目录配置错误。请将网站运行目录配置到meedu程序根目录下的public目录。');
}

$step = (int)($_GET['step'] ?? 0);
$isSubmit = $_POST['submit'] ?? false;

// 已安装的扩展
$extensions = array_flip(get_loaded_extensions());

// 已禁用的函数
$disabledFunctions = array_flip(explode(',', ini_get('disable_functions')));

// 可写路径
$storagePath = realpath(__DIR__ . '/../storage');
$bootstrapPath = realpath(__DIR__ . '/../bootstrap');
$addonsPath = realpath(__DIR__ . '/../addons');

// 要求
$requires = [
    [
        'item' => PHP_VERSION,
        'status' => version_compare('v7.3.0', PHP_VERSION, '<='),
        'intro' => 'PHP版本>=7.3.0',
    ],
    [
        'item' => 'ext-Fileinfo',
        'status' => isset($extensions['fileinfo']),
        'intro' => '安装Fileinfo扩展',
    ],
    [
        'item' => 'ext-BCMath',
        'status' => isset($extensions['bcmath']),
        'intro' => '安装BCMath扩展',
    ],
    [
        'item' => 'ext-Ctype',
        'status' => isset($extensions['ctype']),
        'intro' => '安装Ctype扩展',
    ],
    [
        'item' => 'ext-Json',
        'status' => isset($extensions['json']),
        'intro' => '安装Json扩展',
    ],
    [
        'item' => 'ext-Mbstring',
        'status' => isset($extensions['mbstring']),
        'intro' => '安装Mbstring扩展',
    ],
    [
        'item' => 'ext-OpenSSL',
        'status' => isset($extensions['openssl']),
        'intro' => '安装OpenSSL扩展',
    ],
    [
        'item' => 'ext-PDOMysql',
        'status' => isset($extensions['pdo_mysql']),
        'intro' => '安装PDOMysql扩展',
    ],
    [
        'item' => 'ext-Tokenizer',
        'status' => isset($extensions['tokenizer']),
        'intro' => '安装Tokenizer扩展',
    ],
    [
        'item' => 'ext-XML',
        'status' => isset($extensions['xml']),
        'intro' => '安装XML扩展',
    ],
    [
        'item' => $storagePath,
        'status' => is_writable($storagePath),
        'intro' => '必须可写',
    ],
    [
        'item' => $addonsPath,
        'status' => is_writable($addonsPath),
        'intro' => '必须可写',
    ],
    [
        'item' => $bootstrapPath,
        'status' => is_writable($bootstrapPath),
        'intro' => '必须可写',
    ],
    [
        'item' => 'passthru()',
        'status' => !isset($disabledFunctions['passthru']),
        'intro' => '该函数不能被禁用',
    ],
    [
        'item' => 'proc_open()',
        'status' => !isset($disabledFunctions['proc_open']),
        'intro' => '该函数不能被禁用',
    ],
    [
        'item' => 'proc_get_status()',
        'status' => !isset($disabledFunctions['proc_get_status']),
        'intro' => '该函数不能被禁用',
    ],
    [
        'item' => 'symlink()',
        'status' => !isset($disabledFunctions['symlink']),
        'intro' => '该函数不能被禁用',
    ],
    [
        'item' => 'putenv()',
        'status' => !isset($disabledFunctions['putenv']),
        'intro' => '该函数不能被禁用',
    ],
    [
        'item' => 'pcntl_signal()',
        'status' => !isset($disabledFunctions['pcntl_signal']),
        'intro' => '该函数不能被禁用',
    ],
    [
        'item' => 'pcntl_alarm()',
        'status' => !isset($disabledFunctions['pcntl_alarm']),
        'intro' => '该函数不能被禁用',
    ],
];

$ok = true;
foreach ($requires as $require) {
    if ($require['status'] === false) {
        $ok = false;
        break;
    }
}

if ($step === 0) {
    ?>
    <!doctype html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport"
              content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <link crossorigin="anonymous"
              integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T"
              href="https://lib.baomitu.com/twitter-bootstrap/4.3.1/css/bootstrap.min.css" rel="stylesheet">
        <title>MeEdu安装程序</title>
    </head>
    <body>
    <div class="container">
        <div class="row">
            <div class="col-12 my-5">
                <a href="https://meedu.vip/" target="_blank"><img src="/images/logo.png" height="40"></a>
            </div>
            <div class="col-12 mb-5 text-center">
                <h2>MeEdu 傻瓜安装程序</h2>
            </div>
            <div class="col-12">
                <table class="table table-hover">
                    <thead>
                    <tr class="text-center">
                        <th width="40%">要求</th>
                        <th>状态</th>
                        <th>说明</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php foreach ($requires as $require) { ?>
                        <tr class="text-center">
                            <td><?php echo $require['item']; ?></td>
                            <td><?php echo $require['status'] ? '通过' : '未通过'; ?></td>
                            <td><?php echo $require['intro']; ?></td>
                        </tr>
                    <?php } ?>
                    </tbody>
                </table>
            </div>
            <div class="col-12 my-5 text-right">
                <?php if ($ok) { ?>
                    <a href="?step=1" class="btn btn-info">下一步</a>
                <?php } ?>
            </div>
        </div>
    </div>
    </body>
    </html>
    <?php
} elseif ($step === 1) {
    if (!$ok) {
        alert('安装环境错误');
    }
    $url = $_POST['url'] ?? '';
    $dbHost = $_POST['db_host'] ?? '';
    $dbPort = $_POST['db_port'] ?? '';
    $dbUser = $_POST['db_user'] ?? '';
    $dbPass = $_POST['db_pass'] ?? '';
    $dbDb = $_POST['db_db'] ?? '';

    $dbConnected = false;
    $error = '';
    if ($isSubmit) {
        // 测试数据库连接
        try {
            new PDO('mysql:host=' . $dbHost . ';port=' . $dbPort . ';dbname=' . $dbDb, $dbUser, $dbPass);
            $dbConnected = true;
        } catch (Exception $e) {
            $error = $e->getMessage();
        }

        if ($dbConnected) {
            // 数据库连接成功
            // 将配置写入.env文件

            // 如果未配置协议的话则自动配置协议
            if (mb_substr($url, 0, 4) !== 'http') {
                $url = (is_https() ? 'https://' : 'http://') . $url;
            }

            // 待替换的配置项
            $replaceArr = [
                '{URL}' => $url,
                '{MYSQL_HOST}' => $dbHost,
                '{MYSQL_PORT}' => $dbPort,
                '{MYSQL_DATABASE}' => $dbDb,
                '{MYSQL_USERNAME}' => $dbUser,
                '{MYSQL_PASSWORD}' => $dbPass,
            ];
            $envContent = file_get_contents('../.env.install');
            $envContent = str_replace(array_keys($replaceArr), array_values($replaceArr), $envContent);
            file_put_contents('../.env', $envContent);

            // 执行安装程序
            require '../vendor/autoload.php';
            $app = require_once __DIR__ . '/../bootstrap/app.php';
            $artisan = $app->make(Illuminate\Contracts\Console\Kernel::class);
            $output = $app->make(\Symfony\Component\Console\Output\BufferedOutput::class);

            // key:generate
            $artisan->call('key:generate', ['--force' => true], $output);

            // jwt:secret
            $artisan->call('jwt:secret', ['--force' => true], $output);

            // storage:link
            $artisan->call('storage:link', [], $output);

            // migrate
            $artisan->call('migrate', ['--force' => true], $output);

            // install role
            $artisan->call('install', ['action' => 'role'], $output);

            // install administrator
            $artisan->call('install', ['action' => 'administrator', '-q' => true], $output);

            // config
            $artisan->call('install', ['action' => 'config'], $output);

            exit(redirect($_SERVER['PHP_SELF'] . '?step=2')->getContent());
        }
    }
    ?>
    <!doctype html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport"
              content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <link crossorigin="anonymous"
              integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T"
              href="https://lib.baomitu.com/twitter-bootstrap/4.3.1/css/bootstrap.min.css" rel="stylesheet">
        <title>MeEdu安装程序</title>
    </head>
    <body>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-12 my-5">
                <a href="https://meedu.vip/" target="_blank"><img src="/images/logo.png" height="40"></a>
            </div>
            <div class="col-12 mb-5 text-center">
                <h2>MeEdu安装程序</h2>
            </div>
            <div class="col-4">
                <?php if ($error) { ?>
                    <div class="alert alert-danger">
                        <p class="mb-0"><?php echo $error; ?></p>
                    </div>
                <?php } ?>
                <form action="" method="post">
                    <input type="hidden" name="submit" value="1">
                    <div class="form-group">
                        <label>网站地址</label>
                        <input type="text" name="url" value="<?php echo $url; ?>" class="form-control"
                               placeholder="例如：https://meeedu.vip" required>
                    </div>
                    <div class="form-group">
                        <label>数据库地址</label>
                        <input type="text" name="db_host" value="<?php echo $dbHost; ?>" class="form-control"
                               placeholder="例如：127.0.0.1" required>
                    </div>
                    <div class="form-group">
                        <label>数据库端口</label>
                        <input type="text" name="db_port" value="<?php echo $dbPort; ?>" class="form-control"
                               placeholder="例如：3306" required>
                    </div>
                    <div class="form-group">
                        <label>数据库用户</label>
                        <input type="text" name="db_user" value="<?php echo $dbUser; ?>" class="form-control"
                               placeholder="例如：root" required>
                    </div>
                    <div class="form-group">
                        <label>数据库密码</label>
                        <input type="text" name="db_pass" value="<?php echo $dbPass; ?>" class="form-control"
                               placeholder="为空可不填写">
                    </div>
                    <div class="form-group">
                        <label>数据库</label>
                        <input type="text" name="db_db" value="<?php echo $dbDb; ?>" class="form-control"
                               placeholder="例如：meedu" required>
                    </div>
                    <div class="form-group">
                        <button type="submit" class="btn btn-info btn-block">下一步</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    </body>
    </html>
    <?php
} elseif ($step === 2) {
    // 安装成功
    file_put_contents('../storage/install.lock', time());
    ?>
    <!doctype html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport"
              content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <link crossorigin="anonymous"
              integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T"
              href="https://lib.baomitu.com/twitter-bootstrap/4.3.1/css/bootstrap.min.css" rel="stylesheet">
        <title>MeEdu安装程序</title>
    </head>
    <body>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-12 my-5">
                <a href="https://meedu.vip/" target="_blank"><img src="/images/logo.png" height="40"></a>
            </div>
            <div class="col-12 mb-5 text-center">
                <h2>MeEdu安装程序</h2>
            </div>
            <div class="col-4 text-center">
                <div class="alert alert-warning">
                    <p class="mb-0">请记得删除install.php文件</p>
                    <p class="mb-0">后台账号：<code>meedu@meedu.meedu</code></p>
                    <p class="mb-0">后台密码：<code>meedu123</code></p>
                    <p class="mb-0">登录后台之后记得修改密码哦！</p>
                </div>
                <div class="pb-5">
                    <h3 style="color: green" class="my-5">安装成功</h3>
                    <a href="/" class="btn btn-success">网站首页</a>
                </div>
            </div>
        </div>
    </div>
    </body>
    </html>
    <?php
}