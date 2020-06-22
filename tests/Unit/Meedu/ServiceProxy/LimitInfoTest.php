<?php

/*
 * This file is part of the Qsnh/meedu.
 *
 * (c) XiaoTeng <616896861@qq.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace Tests\Unit\Meedu\ServiceProxy;

use Tests\TestCase;
use App\Meedu\ServiceProxy\Limiter\LimiterInfo;

class LimitInfoTest extends TestCase
{
    public function test()
    {
        $limitInfo = new LimiterInfo('limit', 10, 1);
        $this->assertEquals('limit', $limitInfo->getName());
        $this->assertEquals(1, $limitInfo->getMinutes());
        $this->assertEquals(10, $limitInfo->getMaxTimes());

        $limitInfo->setName('limit1');
        $limitInfo->setMaxTimes(20);
        $limitInfo->setMinutes(2);

        $this->assertEquals('limit1', $limitInfo->getName());
        $this->assertEquals(2, $limitInfo->getMinutes());
        $this->assertEquals(20, $limitInfo->getMaxTimes());
    }
}
