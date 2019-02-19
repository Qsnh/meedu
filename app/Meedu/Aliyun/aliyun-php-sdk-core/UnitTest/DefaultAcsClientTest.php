<?php

/*
 * This file is part of the Qsnh/meedu.
 *
 * (c) XiaoTeng <616896861@qq.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

include_once 'BaseTest.php';
use UnitTest\Ecs\Request as Ecs;
use UnitTest\BatchCompute\Request as BC;

class DefaultAcsClientTest extends BaseTest
{
    public function testDoActionRPC()
    {
        $request = new Ecs\DescribeRegionsRequest();
        $response = $this->client->doAction($request);

        $this->assertNotNull($response->RequestId);
        $this->assertNotNull($response->Regions->Region[0]->LocalName);
        $this->assertNotNull($response->Regions->Region[0]->RegionId);
    }

    public function testDoActionROA()
    {
        $request = new BC\ListImagesRequest();
        $response = $this->client->doAction($request);
        $this->assertNotNull($response);
    }
}
