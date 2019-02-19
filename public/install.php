<?php
header('Content-type:text/html; charset=utf-8');
$lockFile = '../storage/install.lock';
if (file_exists($lockFile)) {
    exit('程序已经安装，请不要重复操作。');
}
if (preg_match('/public/', $_SERVER['REQUEST_URI'])) {
    exit('请apache或nginx的document_root目录配置到项目的public目录下');
}
// PHP版本
$phpVersion = PHP_VERSION;
$phpVersionCould = version_compare($phpVersion, '7.1.3', '>=');
// 目录权限
$bootstrapDirWriteable = is_writable('../bootstrap');
$storageDirWriteable = is_writeable('../storage');
$envWriteable = is_writeable('../.env');
// 扩展
$opensslExtension = extension_loaded('openssl');
$pdoMysqlExtension = extension_loaded('pdo_mysql');
$mbstringExtension = extension_loaded('mbstring');
$tokenizerExtension = extension_loaded('tokenizer');
$xmlExtension = extension_loaded('xml');
$fileinfoExtension = extension_loaded('fileinfo');
$ctypeExtension = extension_loaded('ctype');
$jsonExtension = extension_loaded('json');
$bcmathExtension = extension_loaded('bcmath');
$zipExtension = extension_loaded('zip');
$gdExtension = extension_loaded('gd');
$extensionRows = [
    'openssl' => $opensslExtension,
    'pdo_mysql' => $pdoMysqlExtension,
    'mbstring' => $mbstringExtension,
    'tokenizer' => $tokenizerExtension,
    'xml' => $xmlExtension,
    'fileinfo' => $fileinfoExtension,
    'ctype' => $ctypeExtension,
    'json' => $jsonExtension,
    'bcmath' => $bcmathExtension,
    'zip' => $zipExtension,
    'GD' => $gdExtension,
];
$isCross = $phpVersionCould && $storageDirWriteable && $bootstrapDirWriteable && $envWriteable;
if ($isCross) {
    foreach ($extensionRows as $extensionRow) {
        $isCross = $isCross && $extensionRow;
    }
}
?>
<!doctype html>
<html lang="zh-CN">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link crossorigin="anonymous" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" href="https://lib.baomitu.com/twitter-bootstrap/4.1.3/css/bootstrap.min.css" rel="stylesheet">
    <title>MeEdu安装前检测</title>
</head>
<body>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-sm-12 mb-3 text-center">
                <h2 style="line-height: 160px;">MeEdu安装检测程序</h2>
            </div>
            <div class="col-sm-12">
                <ul class="list-group">
                    <li class="list-group-item list-group-item-info"><b>PHP版本检测(要求版本：>=7.1.3)</b></li>
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        <?php echo $phpVersion; ?>
                        <span class="badge badge-<?php echo $phpVersionCould ? 'success' : 'danger' ?> badge-pill">
                            <?php echo $phpVersionCould ? '通过' : '不通过' ?>
                        </span>
                    </li>
                    <li class="list-group-item list-group-item-info"><b>目录权限可写检测</b></li>
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        <?php echo realpath('../bootstrap'); ?>
                        <span class="badge badge-<?php echo $bootstrapDirWriteable ? 'success' : 'danger' ?> badge-pill">
                            <?php echo $bootstrapDirWriteable ? '可写' : '不可写' ?>
                        </span>
                    </li>
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        <?php echo realpath('../storage'); ?>
                        <span class="badge badge-<?php echo $storageDirWriteable ? 'success' : 'danger' ?> badge-pill">
                            <?php echo $storageDirWriteable ? '可写' : '不可写' ?>
                        </span>
                    </li>
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        <?php echo realpath('../.env'); ?>
                        <span class="badge badge-<?php echo $envWriteable ? 'success' : 'danger' ?> badge-pill">
                            <?php echo $envWriteable ? '可写' : '不可写' ?>
                        </span>
                    </li>
                    <li class="list-group-item list-group-item-info"><b>PHP扩展检测</b></li>
                    <?php foreach($extensionRows as $name => $row) { ?>
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        <?php echo $name; ?>
                        <span class="badge badge-<?php echo $row ? 'success' : 'danger' ?> badge-pill">
                            <?php echo $row ? '已安装' : '未安装' ?>
                        </span>
                    </li>
                    <?php } ?>
                </ul>
            </div>
            <div class="col-sm-12 text-center" style="line-height: 120px;">
                <?php if ($isCross) { ?>
                <a href="/install" class="btn btn-info">继续安装</a>
                <?php } else { ?>
                    <button disabled class="btn btn-info" type="button">无法继续下去啦</button>
                <?php } ?>
            </div>
        </div>
    </div>
</body>
</html>



