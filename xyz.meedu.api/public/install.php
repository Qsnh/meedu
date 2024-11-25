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
    <!DOCTYPE html>
    <html lang="zh-CN">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>MeEdu安装程序</title>
        <style>
            body {
                font-family: Arial, sans-serif;
                background-color: #f3f4f6;
                margin: 0;
                padding: 20px;
                display: flex;
                justify-content: center;
                align-items: center;
                min-height: 100vh;
            }

            .container {
                background-color: white;
                border-radius: 8px;
                box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
                width: 100%;
                max-width: 700px;
                overflow: hidden;
            }

            header {
                background-color: #f9fafb;
                padding: 20px;
                display: flex;
                align-items: center;
                justify-content: space-between;
            }

            .logo-title {
                display: flex;
                align-items: center;
            }

            .logo {
                width: 40px;
                height: 40px;
                margin-right: 10px;
            }

            main {
                padding: 20px;
            }

            h2 {
                font-size: 1.125rem;
                color: #374151;
                margin-bottom: 1rem;
            }

            .check-list {
                list-style: none;
                padding: 0;
            }

            .check-item {
                border-bottom: 1px solid #e5e7eb;
                padding: 10px 0;
            }

            .check-item:last-child {
                border-bottom: none;
            }

            .check-header {
                display: flex;
                justify-content: space-between;
                align-items: center;
                margin-bottom: 5px;
            }

            .check-name {
                font-weight: bold;
            }

            .status {
                width: 20px;
                height: 20px;
                border-radius: 50%;
            }

            .passed {
                background-color: #10b981;
            }

            .failed {
                background-color: #ef4444;
            }

            .check-description {
                font-size: 0.875rem;
                color: #6b7280;
                margin-top: 5px;
            }

            footer {
                background-color: #f9fafb;
                padding: 20px;
                text-align: right;
            }

            .next-button {
                background-color: #3b82f6;
                color: white;
                border: none;
                padding: 10px 20px;
                border-radius: 4px;
                cursor: pointer;
                font-size: 1rem;
                text-decoration: none;
                outline: none;
            }

            .next-button:hover {
                opacity: 0.8;
            }

            .next-button:disabled {
                background-color: #9ca3af;
                cursor: not-allowed;
            }
        </style>
    </head>
    <body>
    <div class="container">
        <header>
            <div class="logo-title">
                <a href="https://meedu.vip/" target="_blank"><img src="/images/logo.png" height="40"></a>
            </div>
        </header>
        <main>
            <h2>环境检测</h2>
            <ul class="check-list">
                <?php foreach ($requires as $require) { ?>
                    <li class="check-item">
                        <div class="check-header">
                            <span class="check-name"><?php echo $require['item']; ?></span>
                            <span class="<?php echo $require['status'] ? 'status passed' : 'status failed'; ?>"></span>
                        </div>
                        <p class="check-description"><?php echo $require['intro'] ?></p>
                    </li>
                <?php } ?>
            </ul>
        </main>
        <footer>
            <?php if (!$ok) { ?>
                <button class="next-button" disabled>下一步</button>
            <?php } else { ?>
                <a href="?step=1" class="next-button">下一步</a>
            <?php } ?>
        </footer>
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
            $pdo = new PDO('mysql:host=' . $dbHost . ';port=' . $dbPort . ';dbname=' . $dbDb, $dbUser, $dbPass);
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
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
    <!DOCTYPE html>
    <html lang="zh-CN">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>MeEdu安装程序 - 数据库配置</title>
        <style>
            body {
                font-family: Arial, sans-serif;
                background-color: #f3f4f6;
                margin: 0;
                padding: 20px;
                display: flex;
                justify-content: center;
                align-items: center;
                min-height: 100vh;
            }

            .container {
                background-color: white;
                border-radius: 8px;
                box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
                width: 100%;
                max-width: 700px;
                overflow: hidden;
            }

            header {
                background-color: #f9fafb;
                padding: 20px 40px 20px 20px;
                display: flex;
                align-items: center;
                justify-content: space-between;
            }

            .logo-title {
                display: flex;
                align-items: center;
            }

            .logo {
                width: 40px;
                height: 40px;
                margin-right: 10px;
            }

            main {
                padding: 20px 40px 20px 20px;
            }

            h2 {
                font-size: 1.125rem;
                color: #374151;
                margin-bottom: 1rem;
            }

            .form-group {
                margin-bottom: 1rem;
            }

            label {
                display: block;
                margin-bottom: 0.5rem;
                font-weight: bold;
                color: #374151;
            }

            input[type="text"],
            input[type="password"] {
                width: 100%;
                padding: 0.5rem;
                border: 1px solid #d1d5db;
                border-radius: 4px;
                font-size: 1rem;
            }

            .hint {
                font-size: 0.875rem;
                color: #6b7280;
                margin-top: 0.25rem;
            }

            footer {
                background-color: #f9fafb;
                padding: 20px 40px 20px 20px;
                text-align: right;
            }

            .next-button {
                background-color: #3b82f6;
                color: white;
                border: none;
                padding: 10px 20px;
                border-radius: 4px;
                cursor: pointer;
                font-size: 1rem;
            }

            .next-button:hover {
                background-color: #2563eb;
            }

            @media (max-width: 640px) {
                header, main, footer {
                    padding-right: 20px;
                }
            }

            .error-message {
                background-color: #fee2e2;
                border: 1px solid #fecaca;
                color: #dc2626;
                padding: 1rem;
                margin: 1rem 20px;
                border-radius: 4px;
                display: flex;
                align-items: center;
                font-size: 1rem;
                font-weight: 500;
                box-shadow: 0 2px 4px rgba(220, 38, 38, 0.1);
            }

            .error-icon {
                width: 24px;
                height: 24px;
                margin-right: 0.75rem;
                flex-shrink: 0;
                color: #dc2626;
            }

            .error-text {
                flex: 1;
                line-height: 1.5;
            }
        </style>
    </head>
    <body>
    <div class="container">
        <header>
            <div class="logo-title">
                <a href="https://meedu.vip/" target="_blank"><img src="/images/logo.png" height="40"></a>
            </div>
        </header>
        <?php
        if ($error) {
            ?>
            <div class="error-message">
                <svg class="error-icon" width="24" height="24" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd"
                          d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z"
                          clip-rule="evenodd"/>
                </svg>
                <span class="error-text">数据库连接失败：<?php echo htmlspecialchars($error); ?></span>
            </div>
            <?php
        }
        ?>
        <form id="dbForm" action="" method="POST">
            <input type="hidden" name="submit" value="1">
            <main>
                <h2>请输入数据库连接信息</h2>
                <div class="form-group">
                    <label for="config-url">访问地址：</label>
                    <input type="text" id="config-url" name="url" value="<?php echo $url; ?>" required>
                    <p class="hint">http://或者https://为前缀开头的URL地址</p>
                </div>
                <div class="form-group">
                    <label for="dbHost">数据库主机：</label>
                    <input type="text" id="dbHost" name="db_host" value="<?php echo $dbHost; ?>" required>
                    <p class="hint">通常为localhost，除非您的数据库在远程服务器上</p>
                </div>
                <div class="form-group">
                    <label for="dbPort">数据库端口：</label>
                    <input type="text" id="dbPort" name="db_port" value="<?php echo $dbPort; ?>" required>
                    <p class="hint">通常为3306端口</p>
                </div>
                <div class="form-group">
                    <label for="dbName">数据库名称：</label>
                    <input type="text" id="dbName" name="db_db" value="<?php echo $dbDb; ?>" required>
                    <p class="hint">请确保该数据库已经创建</p>
                </div>
                <div class="form-group">
                    <label for="dbUser">数据库用户名：</label>
                    <input type="text" id="dbUser" name="db_user" value="<?php echo $dbUser; ?>" required>
                </div>
                <div class="form-group">
                    <label for="dbPassword">数据库密码：</label>
                    <input type="password" id="dbPassword" name="db_pass" value="<?php echo $dbPass; ?>" required>
                </div>
            </main>
            <footer>
                <button type="submit" form="dbForm" class="next-button">下一步</button>
            </footer>
        </form>
    </div>
    </body>
    </html>
    <?php
} elseif ($step === 2) {
    // 安装成功
    file_put_contents('../storage/install.lock', time());
    ?>
    <!DOCTYPE html>
    <html lang="zh-CN">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>MeEdu安装程序 - 安装完成</title>
        <style>
            body {
                font-family: Arial, sans-serif;
                background-color: #f3f4f6;
                margin: 0;
                padding: 20px;
                display: flex;
                justify-content: center;
                align-items: center;
                min-height: 100vh;
            }

            .container {
                background-color: white;
                border-radius: 8px;
                box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
                width: 100%;
                max-width: 600px;
                overflow: hidden;
            }

            header {
                background-color: #f9fafb;
                padding: 20px 40px 20px 20px;
                display: flex;
                align-items: center;
                justify-content: space-between;
            }

            .logo-title {
                display: flex;
                align-items: center;
            }

            .logo {
                width: 40px;
                height: 40px;
                margin-right: 10px;
            }

            main {
                padding: 20px 20px 20px 20px;
            }

            h2 {
                font-size: 1.5rem;
                color: #10b981;
                margin-bottom: 1rem;
                text-align: center;
            }

            .success-message {
                text-align: center;
                margin-bottom: 2rem;
            }

            .admin-info {
                background-color: #f3f4f6;
                border-radius: 8px;
                padding: 20px;
                margin-bottom: 2rem;
            }

            .admin-info h3 {
                font-size: 1.125rem;
                color: #374151;
                margin-top: 0;
                margin-bottom: 1rem;
            }

            .admin-info p {
                margin: 0.5rem 0;
            }

            .warning {
                color: #ef4444;
                font-weight: bold;
            }

            footer {
                background-color: #f9fafb;
                padding: 20px 40px 20px 20px;
                text-align: right;
            }

            .finish-button {
                background-color: #10b981;
                color: white;
                border: none;
                padding: 10px 20px;
                border-radius: 4px;
                cursor: pointer;
                font-size: 1rem;
            }

            .finish-button:hover {
                background-color: #059669;
            }

            @media (max-width: 640px) {
                header, main, footer {
                    padding-right: 20px;
                }
            }
        </style>
    </head>
    <body>
    <div class="container">
        <header>
            <div class="logo-title">
                <a href="https://meedu.vip/" target="_blank"><img src="/images/logo.png" height="40"></a>
            </div>
        </header>
        <main>
            <h2>恭喜！安装成功</h2>
            <div class="success-message">
                <p>MeEdu程序已经成功安装到您的服务器上。您现在可以开始使用了。</p>
            </div>
            <div class="admin-info">
                <h3>管理员账号信息</h3>
                <p><strong>账号：</strong> meedu@meedu.meedu</p>
                <p><strong>密码：</strong> meedu123</p>
                <p class="warning">请立即登录并修改默认密码！</p>
            </div>
        </main>
    </div>
    </body>
    </html>
    <?php
}