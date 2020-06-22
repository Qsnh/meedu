<?php

/*
 * This file is part of the Qsnh/meedu.
 *
 * (c) XiaoTeng <616896861@qq.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace Tests\Unit\Meedu;

use Tests\TestCase;
use App\Meedu\Tencent\Vod;

class VodTest extends TestCase
{
    public function test_vod()
    {
        $vod = new Vod();
        $vod->getUploadSignature();
        $this->assertTrue(true);
    }
}
