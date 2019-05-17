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

class ShaHmac256SignerTest extends PHPUnit_Framework_TestCase
{
    public function testShaHmac256Signer()
    {
        $signer = new ShaHmac256Signer();
        $this->assertEquals(
            'TpF1lE/avV9EHGWGg9Vo/QTd2bLRwFCk9jjo56uRbCo=',
            $signer->signString('this is a ShaHmac256 test.', 'accessSecret')
        );
    }
}
