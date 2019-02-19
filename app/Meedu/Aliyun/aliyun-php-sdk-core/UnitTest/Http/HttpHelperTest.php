<?php

/*
 * This file is part of the Qsnh/meedu.
 *
 * (c) XiaoTeng <616896861@qq.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

include_once '../BaseTest.php';
class HttpHelperTest extends BaseTest
{
    public function testCurl()
    {
        $httpResponse = HttpHelper::curl('ecs.aliyuncs.com');
        $this->assertEquals(400, $httpResponse->getStatus());
        $this->assertNotNull($httpResponse->getBody());
    }
}
