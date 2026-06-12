<?php

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

function shell_html($title, $eyebrow, $body)
{
    header('Content-type: text/html; charset="UTF-8"');
    $titleSafe = htmlspecialchars($title, ENT_QUOTES, 'UTF-8');
    $eyebrowSafe = htmlspecialchars($eyebrow, ENT_QUOTES, 'UTF-8');
    echo <<<HTML
<!DOCTYPE html>
<html lang="zh-CN">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>{$titleSafe} · MeEdu 安装</title>
<style>
:root {
    --color-primary: #3ca7fa;
    --color-success: #04c877;
    --color-danger: #ff4d4f;
    --color-bg: #f4fafe;
    --color-surface: #ffffff;
    --color-text-primary: #213547;
    --color-text-secondary: rgba(0, 0, 0, 0.45);
    --color-text-tertiary: #999999;
    --color-divider: #e5e5e5;
    --color-border: #d9d9d9;
    --font-stack: "Inter", system-ui, Avenir, Helvetica, Arial, sans-serif;
}

* {
    box-sizing: border-box;
}

html, body {
    margin: 0;
    padding: 0;
}

body {
    font-family: var(--font-stack);
    font-size: 14px;
    line-height: 1.5;
    color: var(--color-text-primary);
    background-color: var(--color-bg);
    background-image:
        radial-gradient(circle at 12% 18%, rgba(60, 167, 250, 0.08), transparent 42%),
        radial-gradient(circle at 88% 82%, rgba(60, 167, 250, 0.06), transparent 46%);
    min-height: 100vh;
    -webkit-font-smoothing: antialiased;
    -moz-osx-font-smoothing: grayscale;
}

.page {
    width: 100%;
    min-height: 100vh;
    display: flex;
    align-items: center;
    justify-content: center;
    padding: 48px 16px;
}

.card {
    width: 100%;
    max-width: 520px;
    background-color: var(--color-surface);
    border-radius: 4px;
    box-shadow: 20px 20px 100px 0 rgba(85, 102, 119, 0.1);
    padding: 40px 36px;
}

.brand {
    display: flex;
    align-items: center;
    margin-bottom: 28px;
}

.brand img {
    height: 26px;
    display: block;
}

.eyebrow {
    display: inline-block;
    font-size: 12px;
    font-weight: 500;
    line-height: 1;
    letter-spacing: 0.14em;
    color: var(--color-primary);
    margin-bottom: 12px;
    text-transform: uppercase;
}

.title {
    font-size: 24px;
    font-weight: 500;
    line-height: 1.25;
    color: var(--color-text-primary);
    margin: 0 0 8px;
}

.subtitle {
    font-size: 14px;
    font-weight: 400;
    line-height: 1.5;
    color: var(--color-text-secondary);
    margin: 0 0 28px;
    max-width: 60ch;
}

.check-list {
    list-style: none;
    margin: 0;
    padding: 0;
    border-top: 1px solid var(--color-divider);
}

.check-item {
    padding: 12px 0;
    border-bottom: 1px solid var(--color-divider);
}

.check-item.failed {
    background-color: rgba(255, 77, 79, 0.04);
    margin: 0 -12px;
    padding-left: 12px;
    padding-right: 12px;
    border-bottom-color: rgba(255, 77, 79, 0.18);
}

.check-row {
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 16px;
}

.check-name {
    font-size: 14px;
    font-weight: 500;
    color: var(--color-text-primary);
    word-break: break-all;
}

.check-state {
    display: inline-flex;
    align-items: center;
    gap: 6px;
    flex-shrink: 0;
    font-size: 12px;
    line-height: 1;
    color: var(--color-text-tertiary);
}

.check-state .dot {
    width: 8px;
    height: 8px;
    border-radius: 50%;
    background-color: var(--color-text-tertiary);
}

.check-state.passed { color: var(--color-success); }
.check-state.passed .dot { background-color: var(--color-success); }

.check-state.failed { color: var(--color-danger); }
.check-state.failed .dot { background-color: var(--color-danger); }

.check-hint {
    margin: 6px 0 0;
    font-size: 12px;
    line-height: 1.5;
    color: var(--color-text-tertiary);
}

.check-item.failed .check-hint {
    color: var(--color-danger);
}

.summary {
    margin-top: 20px;
    font-size: 12px;
    line-height: 1.5;
    color: var(--color-text-secondary);
}

.summary.failed {
    color: var(--color-danger);
}

.form {
    display: flex;
    flex-direction: column;
    gap: 18px;
}

.field {
    display: flex;
    flex-direction: column;
    gap: 6px;
}

.field-label {
    font-size: 14px;
    font-weight: 500;
    color: var(--color-text-primary);
    line-height: 22px;
}

.field-label .req {
    color: var(--color-danger);
    margin-right: 4px;
}

.field-input {
    width: 100%;
    height: 36px;
    padding: 0 12px;
    background-color: var(--color-surface);
    border: 1px solid var(--color-border);
    border-radius: 4px;
    color: var(--color-text-primary);
    font-family: var(--font-stack);
    font-size: 14px;
    line-height: 1.5;
    outline: none;
    transition: border-color 120ms ease-out, box-shadow 120ms ease-out;
}

.field-input::placeholder {
    color: var(--color-text-tertiary);
}

.field-input:focus {
    border-color: var(--color-primary);
    box-shadow: 0 0 0 2px rgba(60, 167, 250, 0.2);
}

.field-hint {
    font-size: 12px;
    line-height: 1.5;
    color: var(--color-text-secondary);
}

.error-block {
    margin-bottom: 24px;
    padding: 12px 14px;
    border: 1px solid var(--color-danger);
    border-radius: 4px;
    background-color: rgba(255, 77, 79, 0.04);
    display: flex;
    gap: 10px;
    align-items: flex-start;
}

.error-block .error-dot {
    width: 8px;
    height: 8px;
    border-radius: 50%;
    background-color: var(--color-danger);
    margin-top: 7px;
    flex-shrink: 0;
}

.error-block .error-body {
    flex: 1;
    min-width: 0;
}

.error-block .error-title {
    font-size: 14px;
    font-weight: 500;
    color: var(--color-danger);
    line-height: 1.5;
}

.error-block .error-detail {
    margin-top: 4px;
    font-size: 12px;
    line-height: 1.5;
    color: var(--color-text-primary);
    word-break: break-all;
}

.error-block .error-hint {
    margin-top: 6px;
    font-size: 12px;
    line-height: 1.5;
    color: var(--color-text-secondary);
}

.actions {
    margin-top: 28px;
    display: flex;
    flex-direction: column;
    gap: 12px;
}

.btn-primary {
    appearance: none;
    width: 100%;
    height: 44px;
    padding: 0 20px;
    border: none;
    border-radius: 4px;
    background-color: var(--color-primary);
    color: var(--color-surface);
    font-family: var(--font-stack);
    font-size: 14px;
    font-weight: 500;
    line-height: 1;
    cursor: pointer;
    text-decoration: none;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    transition: background-color 120ms ease-out, opacity 120ms ease-out;
}

.btn-primary:hover {
    background-color: #4eb0fb;
}

.btn-primary:focus-visible {
    outline: 2px solid var(--color-primary);
    outline-offset: 2px;
}

.btn-primary:disabled,
.btn-primary.is-disabled {
    background-color: var(--color-border);
    color: var(--color-surface);
    cursor: not-allowed;
}

.action-note {
    font-size: 12px;
    line-height: 1.5;
    color: var(--color-text-tertiary);
    text-align: center;
}

.action-note strong {
    color: var(--color-text-primary);
    font-weight: 500;
}

.success-state {
    display: flex;
    align-items: center;
    gap: 8px;
    margin-bottom: 16px;
    font-size: 12px;
    line-height: 1;
    color: var(--color-success);
    font-weight: 500;
}

.success-state .dot {
    width: 8px;
    height: 8px;
    border-radius: 50%;
    background-color: var(--color-success);
}

.next-steps {
    margin-top: 24px;
    padding-top: 20px;
    border-top: 1px solid var(--color-divider);
}

.next-steps h3 {
    margin: 0 0 12px;
    font-size: 16px;
    font-weight: 500;
    color: var(--color-text-primary);
    line-height: 1.5;
}

.next-steps ol {
    margin: 0;
    padding-left: 20px;
    font-size: 14px;
    line-height: 1.7;
    color: var(--color-text-primary);
}

.next-steps ol code {
    font-family: "SFMono-Regular", Consolas, Menlo, monospace;
    font-size: 12.5px;
    background-color: var(--color-bg);
    padding: 1px 6px;
    border-radius: 4px;
    color: var(--color-text-primary);
}

@media (max-width: 520px) {
    .page { padding: 24px 12px; }
    body { background-image: none; }
    .card {
        padding: 28px 20px;
        box-shadow: none;
        border: 1px solid var(--color-divider);
    }
    .title { font-size: 20px; }
}

@media (prefers-reduced-motion: reduce) {
    .field-input,
    .btn-primary {
        transition: none;
    }
}
</style>
</head>
<body>
<div class="page">
    <div class="card">
        <div class="brand">
            <a href="https://meedu.vip/" target="_blank" rel="noopener"><img src="/images/logo.png" alt="MeEdu"></a>
        </div>
        <div class="eyebrow">{$eyebrowSafe}</div>
        {$body}
    </div>
</div>
</body>
</html>
HTML;
}

function alert_page($title, $detail, $hint = '')
{
    $detailSafe = htmlspecialchars($detail, ENT_QUOTES, 'UTF-8');
    $hintHtml = '';
    if ($hint !== '') {
        $hintHtml = '<p class="error-hint">' . htmlspecialchars($hint, ENT_QUOTES, 'UTF-8') . '</p>';
    }
    $body = <<<HTML
<h1 class="title">无法继续安装</h1>
<p class="subtitle">请根据下方提示处理后重新打开此页面。</p>
<div class="error-block" role="alert">
    <span class="error-dot" aria-hidden="true"></span>
    <div class="error-body">
        <div class="error-title">{$detailSafe}</div>
        {$hintHtml}
    </div>
</div>
HTML;
    shell_html($title, 'MeEdu 安装', $body);
    exit;
}

if (file_exists('../storage/install.lock')) {
    http_response_code(404);
    exit;
}

$uri = $_SERVER['REQUEST_URI'];
if (mb_substr($uri, 0, 7) === '/public') {
    alert_page(
        '根目录配置错误',
        '当前请求路径以 /public 开头，说明 Web 服务的根目录指向了 MeEdu 程序根目录，而不是其下的 public 目录。',
        '请将 Nginx / Apache 的站点根目录改为 MeEdu 程序根目录下的 public 子目录后再访问本页。'
    );
}

$step = (int)($_GET['step'] ?? 0);
$isSubmit = $_POST['submit'] ?? false;

$extensions = array_flip(get_loaded_extensions());
$disabledFunctions = array_flip(explode(',', ini_get('disable_functions')));

$storagePath = realpath(__DIR__ . '/../storage');
$bootstrapPath = realpath(__DIR__ . '/../bootstrap');
$addonsPath = realpath(__DIR__ . '/../addons');

$requires = [
    [
        'item' => 'PHP ' . PHP_VERSION,
        'status' => version_compare('v7.3.0', PHP_VERSION, '<='),
        'intro' => '要求 PHP 版本 ≥ 7.3.0',
    ],
    ['item' => 'ext-Fileinfo', 'status' => isset($extensions['fileinfo']), 'intro' => '请安装 Fileinfo 扩展'],
    ['item' => 'ext-BCMath',   'status' => isset($extensions['bcmath']),   'intro' => '请安装 BCMath 扩展'],
    ['item' => 'ext-Ctype',    'status' => isset($extensions['ctype']),    'intro' => '请安装 Ctype 扩展'],
    ['item' => 'ext-Json',     'status' => isset($extensions['json']),     'intro' => '请安装 Json 扩展'],
    ['item' => 'ext-Mbstring', 'status' => isset($extensions['mbstring']), 'intro' => '请安装 Mbstring 扩展'],
    ['item' => 'ext-OpenSSL',  'status' => isset($extensions['openssl']),  'intro' => '请安装 OpenSSL 扩展'],
    ['item' => 'ext-PDOMysql', 'status' => isset($extensions['pdo_mysql']),'intro' => '请安装 PDOMysql 扩展'],
    ['item' => 'ext-Tokenizer','status' => isset($extensions['tokenizer']),'intro' => '请安装 Tokenizer 扩展'],
    ['item' => 'ext-XML',      'status' => isset($extensions['xml']),      'intro' => '请安装 XML 扩展'],
    [
        'item' => $storagePath ?: __DIR__ . '/../storage',
        'status' => $storagePath !== false && is_writable($storagePath),
        'intro' => '该目录必须存在且可写',
    ],
    [
        'item' => $addonsPath ?: __DIR__ . '/../addons',
        'status' => $addonsPath !== false && is_writable($addonsPath),
        'intro' => '该目录必须存在且可写',
    ],
    [
        'item' => $bootstrapPath ?: __DIR__ . '/../bootstrap',
        'status' => $bootstrapPath !== false && is_writable($bootstrapPath),
        'intro' => '该目录必须存在且可写',
    ],
    ['item' => 'passthru()',       'status' => !isset($disabledFunctions['passthru']),       'intro' => '该函数不能被 disable_functions 禁用'],
    ['item' => 'proc_open()',      'status' => !isset($disabledFunctions['proc_open']),      'intro' => '该函数不能被 disable_functions 禁用'],
    ['item' => 'proc_get_status()','status' => !isset($disabledFunctions['proc_get_status']),'intro' => '该函数不能被 disable_functions 禁用'],
    ['item' => 'symlink()',        'status' => !isset($disabledFunctions['symlink']),        'intro' => '该函数不能被 disable_functions 禁用'],
    ['item' => 'putenv()',         'status' => !isset($disabledFunctions['putenv']),         'intro' => '该函数不能被 disable_functions 禁用'],
    ['item' => 'pcntl_signal()',   'status' => !isset($disabledFunctions['pcntl_signal']),   'intro' => '该函数不能被 disable_functions 禁用'],
    ['item' => 'pcntl_alarm()',    'status' => !isset($disabledFunctions['pcntl_alarm']),    'intro' => '该函数不能被 disable_functions 禁用'],
];

$ok = true;
$failedCount = 0;
foreach ($requires as $require) {
    if ($require['status'] === false) {
        $ok = false;
        $failedCount++;
    }
}

if ($step === 0) {
    ob_start();
    ?>
    <h1 class="title">环境检测</h1>
    <p class="subtitle">检查当前服务器是否满足 MeEdu 的运行要求。通过后即可继续配置数据库。</p>

    <ul class="check-list" aria-label="环境检测结果">
        <?php foreach ($requires as $require): ?>
            <?php $passed = (bool)$require['status']; ?>
            <li class="check-item <?php echo $passed ? '' : 'failed'; ?>">
                <div class="check-row">
                    <span class="check-name"><?php echo htmlspecialchars($require['item'], ENT_QUOTES, 'UTF-8'); ?></span>
                    <span class="check-state <?php echo $passed ? 'passed' : 'failed'; ?>" aria-label="<?php echo $passed ? '通过' : '未通过'; ?>">
                        <span class="dot" aria-hidden="true"></span>
                        <?php echo $passed ? '通过' : '未通过'; ?>
                    </span>
                </div>
                <p class="check-hint"><?php echo htmlspecialchars($require['intro'], ENT_QUOTES, 'UTF-8'); ?></p>
            </li>
        <?php endforeach; ?>
    </ul>

    <?php if ($ok): ?>
        <p class="summary">全部 <?php echo count($requires); ?> 项检查通过，可以继续下一步。</p>
        <div class="actions">
            <a href="?step=1" class="btn-primary">下一步：配置数据库</a>
        </div>
    <?php else: ?>
        <p class="summary failed">有 <?php echo $failedCount; ?> 项未通过，请按上方说明在服务器上处理后刷新本页重新检测。</p>
        <div class="actions">
            <button type="button" class="btn-primary is-disabled" disabled>下一步：配置数据库</button>
            <span class="action-note">处理完毕后请<a href="?step=0" style="color: var(--color-primary); text-decoration: none;">刷新本页</a>重新检测。</span>
        </div>
    <?php endif; ?>
    <?php
    $body = ob_get_clean();
    shell_html('环境检测', '第 1 步 / 共 3 步', $body);
} elseif ($step === 1) {
    if (!$ok) {
        alert_page(
            '环境检测未通过',
            '检测到上一步存在未满足的运行要求，无法进入数据库配置。',
            '请返回环境检测页排查未通过项后再继续。'
        );
    }
    $url = (string)($_POST['url'] ?? '');
    $dbHost = (string)($_POST['db_host'] ?? '');
    $dbPort = (string)($_POST['db_port'] ?? '');
    $dbUser = (string)($_POST['db_user'] ?? '');
    $dbPass = (string)($_POST['db_pass'] ?? '');
    $dbDb = (string)($_POST['db_db'] ?? '');

    $dbConnected = false;
    $error = '';
    if ($isSubmit) {
        try {
            $pdo = new PDO('mysql:host=' . $dbHost . ';port=' . $dbPort . ';dbname=' . $dbDb, $dbUser, $dbPass);
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $dbConnected = true;
        } catch (Exception $e) {
            $error = $e->getMessage();
        }

        if ($dbConnected) {
            if (mb_substr($url, 0, 4) !== 'http') {
                $url = (is_https() ? 'https://' : 'http://') . $url;
            }

            // 直接用 CSPRNG 生成敏感密钥,与 DB 配置一同写入 .env;
            // 避免空密钥的 .env 提前触发 AppServiceProvider 的安全校验,导致后续 artisan 无法执行
            $appKey = 'base64:' . base64_encode(random_bytes(32));
            $jwtSecret = bin2hex(random_bytes(32));

            $replaceArr = [
                '{URL}' => $url,
                '{APP_KEY}' => $appKey,
                '{JWT_SECRET}' => $jwtSecret,
                '{MYSQL_HOST}' => $dbHost,
                '{MYSQL_PORT}' => $dbPort,
                '{MYSQL_DATABASE}' => $dbDb,
                '{MYSQL_USERNAME}' => $dbUser,
                '{MYSQL_PASSWORD}' => $dbPass,
            ];
            $envContent = file_get_contents('../.env.install');
            $envContent = str_replace(array_keys($replaceArr), array_values($replaceArr), $envContent);
            file_put_contents('../.env', $envContent);

            require '../vendor/autoload.php';
            $app = require_once __DIR__ . '/../bootstrap/app.php';
            $artisan = $app->make(Illuminate\Contracts\Console\Kernel::class);
            $output = $app->make(\Symfony\Component\Console\Output\BufferedOutput::class);

            $artisan->call('storage:link', [], $output);
            $artisan->call('migrate', ['--force' => true], $output);
            $artisan->call('install', ['action' => 'role'], $output);
            $artisan->call('install', ['action' => 'config'], $output);

            exit(redirect($_SERVER['PHP_SELF'] . '?step=2')->getContent());
        }
    }

    $h = function ($v) { return htmlspecialchars((string)$v, ENT_QUOTES, 'UTF-8'); };
    ob_start();
    ?>
    <h1 class="title">数据库配置</h1>
    <p class="subtitle">填写访问地址与 MySQL 连接信息，提交后将自动写入 .env 并执行迁移。</p>

    <?php if ($error !== ''): ?>
        <div class="error-block" role="alert">
            <span class="error-dot" aria-hidden="true"></span>
            <div class="error-body">
                <div class="error-title">数据库连接失败</div>
                <div class="error-detail"><?php echo $h($error); ?></div>
                <p class="error-hint">请确认主机、端口、用户名、密码及数据库名是否正确，且数据库已创建。</p>
            </div>
        </div>
    <?php endif; ?>

    <form id="dbForm" action="" method="POST" class="form" autocomplete="off">
        <input type="hidden" name="submit" value="1">

        <div class="field">
            <label class="field-label" for="config-url"><span class="req" aria-hidden="true">*</span>访问地址</label>
            <input class="field-input" type="text" id="config-url" name="url" value="<?php echo $h($url); ?>" placeholder="例如 https://meedu.example.com" required>
            <p class="field-hint">建议以 http:// 或 https:// 开头；未填写协议时将根据当前请求自动补全。</p>
        </div>

        <div class="field">
            <label class="field-label" for="dbHost"><span class="req" aria-hidden="true">*</span>数据库主机</label>
            <input class="field-input" type="text" id="dbHost" name="db_host" value="<?php echo $h($dbHost); ?>" placeholder="localhost" required>
            <p class="field-hint">数据库与当前服务器在同一台机器时通常填 localhost 或 127.0.0.1。</p>
        </div>

        <div class="field">
            <label class="field-label" for="dbPort"><span class="req" aria-hidden="true">*</span>数据库端口</label>
            <input class="field-input" type="text" id="dbPort" name="db_port" value="<?php echo $h($dbPort); ?>" placeholder="3306" required>
            <p class="field-hint">MySQL 默认端口为 3306。</p>
        </div>

        <div class="field">
            <label class="field-label" for="dbName"><span class="req" aria-hidden="true">*</span>数据库名称</label>
            <input class="field-input" type="text" id="dbName" name="db_db" value="<?php echo $h($dbDb); ?>" placeholder="meedu" required>
            <p class="field-hint">请确保该数据库已经创建并为空。</p>
        </div>

        <div class="field">
            <label class="field-label" for="dbUser"><span class="req" aria-hidden="true">*</span>数据库用户名</label>
            <input class="field-input" type="text" id="dbUser" name="db_user" value="<?php echo $h($dbUser); ?>" required>
        </div>

        <div class="field">
            <label class="field-label" for="dbPassword"><span class="req" aria-hidden="true">*</span>数据库密码</label>
            <input class="field-input" type="password" id="dbPassword" name="db_pass" value="<?php echo $h($dbPass); ?>" required>
        </div>

        <div class="actions">
            <button type="submit" class="btn-primary">连接数据库并开始安装</button>
            <span class="action-note">提交后将执行数据库迁移与初始化命令，请勿关闭页面。</span>
        </div>
    </form>
    <?php
    $body = ob_get_clean();
    shell_html('数据库配置', '第 2 步 / 共 3 步', $body);
} elseif ($step === 2) {
    file_put_contents('../storage/install.lock', time());
    ob_start();
    ?>
    <div class="success-state">
        <span class="dot" aria-hidden="true"></span>
        安装成功
    </div>
    <h1 class="title">MeEdu 已部署到这台服务器</h1>
    <p class="subtitle">配置已写入 .env，数据库迁移与初始化命令已执行完成。接下来请前往 admin 后台完成超级管理员初始化。</p>

    <div class="next-steps">
        <h3>后续步骤</h3>
        <ol>
            <li>访问 admin 后台首页（独立部署，地址由你在 admin 的环境变量中配置）。</li>
            <li>按引导填写姓名、邮箱、密码，创建第一个超级管理员。</li>
            <li>使用该邮箱与密码登录，开始配置课程与运营。</li>
        </ol>
    </div>
    <?php
    $body = ob_get_clean();
    shell_html('安装完成', '第 3 步 / 共 3 步', $body);
}
