<?php

/*
 * This file is part of the Qsnh/meedu.
 *
 * (c) 杭州白书科技有限公司
 */

namespace Tests\Unit\Meedu\ServiceProxy;

use Tests\TestCase;
use App\Meedu\ServiceProxy\Lock\LockInfo;

class LockInfoTest extends TestCase
{
    public function test()
    {
        $lockInfo = new LockInfo('lock', 10);
        $this->assertEquals('lock', $lockInfo->getName());
        $this->assertEquals(10, $lockInfo->getSeconds());

        $lockInfo->setName('lock1');
        $lockInfo->setSeconds(20);
        $this->assertEquals('lock1', $lockInfo->getName());
        $this->assertEquals(20, $lockInfo->getSeconds());
    }
}
