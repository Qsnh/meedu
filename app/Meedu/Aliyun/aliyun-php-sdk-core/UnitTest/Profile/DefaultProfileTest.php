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
class DefaultProfileTest extends PHPUnit_Framework_TestCase
{
    public function testGetProfile()
    {
        $profile = DefaultProfile::getProfile('cn-hangzhou', 'accessId', 'accessSecret');
        $this->assertEquals('cn-hangzhou', $profile->getRegionId());
        $this->assertEquals('accessId', $profile->getCredential()->getAccessKeyId());
        $this->assertEquals('accessSecret', $profile->getCredential()->getAccessSecret());
    }

    public function testAddEndpoint()
    {
        $profile = DefaultProfile::getProfile('cn-hangzhou', 'accessId', 'accessSecret');
        $profile->addEndpoint('cn-hangzhou', 'cn-hangzhou', 'TestProduct', 'testproduct.aliyuncs.com');
        $endpoints = $profile->getEndpoints();
        foreach ($endpoints as $key => $endpoint) {
            if ('cn-hangzhou' == $endpoint->getName()) {
                $regionIds = $endpoint->getRegionIds();
                $this->assertContains('cn-hangzhou', $regionIds);

                $productDomains = $endpoint->getProductDomains();
                $this->assertNotNull($productDomains);
                $productDomain = $this->getProductDomain($productDomains);
                $this->assertNotNull($productDomain);
                $this->assertEquals('TestProduct', $productDomain->getProductName());
                $this->assertEquals('testproduct.aliyuncs.com', $productDomain->getDomainName());
            }
        }
    }

    private function getProductDomain($productDomains)
    {
        foreach ($productDomains as $productDomain) {
            if ($productDomain->getProductName() == 'TestProduct') {
                return $productDomain;
            }
        }

        return null;
    }
}
