<?php

/*
 * This file is part of the Qsnh/meedu.
 *
 * (c) XiaoTeng <616896861@qq.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

include_once 'Autoloader/Autoloader.php';
include_once 'Regions/EndpointConfig.php';
include_once 'Regions/LocationService.php';

//config sdk auto load path.
AliyunSdkAutoloader::addAutoloadPath('aliyun-php-sdk-vod');
//config http proxy
! defined('ENABLE_HTTP_PROXY') && define('ENABLE_HTTP_PROXY', false);
! defined('HTTP_PROXY_IP') && define('HTTP_PROXY_IP', '127.0.0.1');
! defined('HTTP_PROXY_PORT') && define('HTTP_PROXY_PORT', '8888');
