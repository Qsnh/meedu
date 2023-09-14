<?php

/*
 * This file is part of the MeEdu.
 *
 * (c) 杭州白书科技有限公司
 */

namespace Tests\Unit\Meedu\ServiceProxy;

use Tests\TestCase;
use App\Meedu\ServiceProxy\Cache\CacheInfo;

class CacheInfoTest extends TestCase
{
    public function test_cacheInfo()
    {
        $cacheInfo = new CacheInfo('c', 1200);
        $this->assertEquals('c', $cacheInfo->getName());
        $this->assertEquals(1200, $cacheInfo->getExpire());

        $cacheInfo->setName('b');
        $cacheInfo->setExpire(1300);
        $this->assertEquals('b', $cacheInfo->getName());
        $this->assertEquals(1300, $cacheInfo->getExpire());
    }
}
