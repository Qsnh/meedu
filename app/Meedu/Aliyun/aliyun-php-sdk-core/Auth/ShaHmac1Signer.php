<?php

/*
 * This file is part of the Qsnh/meedu.
 *
 * (c) XiaoTeng <616896861@qq.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

class ShaHmac1Signer implements ISigner
{
    public function signString($source, $accessSecret)
    {
        return    base64_encode(hash_hmac('sha1', $source, $accessSecret, true));
    }

    public function getSignatureMethod()
    {
        return 'HMAC-SHA1';
    }

    public function getSignatureVersion()
    {
        return '1.0';
    }
}
