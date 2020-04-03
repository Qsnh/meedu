<?php

/*
 * This file is part of the Qsnh/meedu.
 *
 * (c) XiaoTeng <616896861@qq.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace App\Meedu\Tencent;

class Vod
{
    protected $secretId;
    protected $secretKey;

    public function __construct()
    {
        $this->secretId = config('tencent.vod.secret_id');
        $this->secretKey = config('tencent.vod.secret_key');
    }

    /**
     * 获取上传签名
     * @return string
     * @throws \Exception
     */
    public function getUploadSignature()
    {
        $currentTime = time();
        $data = [
            'secretId' => $this->secretId,
            'currentTimeStamp' => $currentTime,
            'expireTime' => $currentTime + 86400,
            'random' => random_int(0, 100000),
        ];
        $queryString = http_build_query($data);
        $sign = base64_encode(hash_hmac('sha1', $queryString, $this->secretKey, true) . $queryString);

        return $sign;
    }
}
