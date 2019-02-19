<?php

/*
 * This file is part of the Qsnh/meedu.
 *
 * (c) XiaoTeng <616896861@qq.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

class BaseTest extends PHPUnit_Framework_TestCase
{
    public $client = null;

    public function setUp()
    {
        $path = substr(dirname(__FILE__), 0, strripos(dirname(__FILE__), DIRECTORY_SEPARATOR)).DIRECTORY_SEPARATOR;
        include_once $path.'Config.php';
        include_once 'Ecs/Rquest/DescribeRegionsRequest.php';
        include_once 'BatchCompute/ListImagesRequest.php';

        $iClientProfile = DefaultProfile::getProfile('cn-hangzhou', 'AccessKey', 'AccessSecret');
        $this->client = new DefaultAcsClient($iClientProfile);
    }

    public function getProperty($propertyKey)
    {
        $accessKey = '';
        $accessSecret = '';
        $iClientProfile = DefaultProfile::getProfile('cn-hangzhou', 'AccessKey', 'AccessSecret');
    }
}
