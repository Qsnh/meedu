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
class CredentialTest extends PHPUnit_Framework_TestCase
{
    public function testCredential()
    {
        $credential = new Credential('accessKeyId', 'accessSecret');
        $this->assertEquals('accessKeyId', $credential->getAccessKeyId());
        $this->assertEquals('accessSecret', $credential->getAccessSecret());
        $this->assertNotNull($credential->getRefreshDate());

        $dateNow = date("Y-m-d\TH:i:s\Z");
        $credential->setExpiredDate(1);
        $this->assertNotNull($credential->getExpiredDate());
        $this->assertTrue($credential->getExpiredDate() > $dateNow);
    }
}
