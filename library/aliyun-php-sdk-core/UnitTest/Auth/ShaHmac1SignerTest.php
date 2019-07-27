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
class ShaHmac1SignerTest extends PHPUnit_Framework_TestCase
{
    public function testShaHmac1Signer()
    {
        $signer = new ShaHmac1Signer();
        $this->assertEquals('33nmIV5/p6kG/64eLXNljJ5vw84=', $signer->signString('this is a ShaHmac1 test.', 'accessSecret'));
    }
}
