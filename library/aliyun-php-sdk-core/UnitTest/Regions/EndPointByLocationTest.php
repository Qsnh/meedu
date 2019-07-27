<?php

/*
 * This file is part of the Qsnh/meedu.
 *
 * (c) XiaoTeng <616896861@qq.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

include_once '../../Config.php';

use PHPUnit\Framework\TestCase;

class EndPointByLocationTest extends TestCase
{
    private $locationService;

    private $clientProfile;

    private function initClient()
    {
        // 创建 DefaultAcsClient 实例并初始化
        $this->clientProfile = DefaultProfile::getProfile(
            'cn-shanghai',                   // 您的 Region ID
            '<your AK>',               // 您的 Access Key ID
            '<your Secret>'            // 您的 Access Key Secret
        );

        $this->locationService = new LocationService($this->clientProfile);
    }

    public function testFindProductDomain()
    {
        $this->initClient();
        $domain = $this->locationService->findProductDomain('cn-shanghai', 'apigateway', 'openAPI', 'CloudAPI');
        $this->assertEquals('apigateway.cn-shanghai.aliyuncs.com', $domain);
    }

    public function testFindProductDomainWithAddEndPoint()
    {
        DefaultProfile::addEndpoint('cn-shanghai', 'cn-shanghai', 'CloudAPI', 'apigateway.cn-shanghai123.aliyuncs.com');
        $this->initClient();
        $domain = $this->locationService->findProductDomain('cn-shanghai', 'apigateway', 'openAPI', 'CloudAPI');
        $this->assertEquals('apigateway.cn-shanghai123.aliyuncs.com', $domain);
    }
}
