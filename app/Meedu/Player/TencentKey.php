<?php

/*
 * This file is part of the Qsnh/meedu.
 *
 * (c) XiaoTeng <616896861@qq.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace App\Meedu\Player;

use Illuminate\Support\Str;

class TencentKey
{
    protected $key;

    public function __construct()
    {
        $this->key = config('meedu.system.player.tencent_play_key');
    }

    /**
     * @param $url
     * @param int $isTry
     * @param array $video
     * @return string
     */
    public function url($url, $isTry = 0, array $video = [])
    {
        $urlInfo = parse_url($url);
        $dir = pathinfo($urlInfo['path'], PATHINFO_DIRNAME) . '/';
        // 默认三个小时
        $t = time() + 3600 * 1.5;
        // 试看
        $exper = $isTry ? ($video['free_seconds'] ?? 0) : 0;
        // 最多只允许一个ip访问
        $rlimit = 1;
        $us = Str::random(16);
        $sign = md5($this->key . $dir . $t . $exper . $rlimit . $us);
        return sprintf('%s?t=%s&exper=%d&rlimit=%d&us=%s&sign=%s', $url, $t, $exper, $rlimit, $us, $sign);
    }

    public function psign(array $video, $isTry = false): string
    {
        if (!$this->key) {
            return '';
        }
        $header = [
            'alg' => 'HS256',
            'typ' => 'JWT',
        ];
        $data = [
            'appId' => (int)config('tencent.vod.app_id'),
            'fileId' => $video['tencent_video_id'],
            'currentTimeStamp' => time(),
            'expireTimeStamp' => time() + 3600 * 1.5,
            'urlAccessInfo' => [
                'rlimit' => 1,
                'us' => Str::random(6),
            ],
        ];
        if ($isTry) {
            $data['urlAccessInfo']['exper'] = (int)($video['free_seconds'] / 0.8);
        }
        $headerEncode = $this->base64UrlEncode(json_encode($header, JSON_UNESCAPED_UNICODE));
        $dataEncode = $this->base64UrlEncode(json_encode($data, JSON_UNESCAPED_UNICODE));
        $sign = $this->base64UrlEncode(hash_hmac('sha256', $headerEncode . '.' . $dataEncode, $this->key, true));
        $result = $headerEncode . '.' . $dataEncode . '.' . $sign;
        return $result;
    }

    private function base64UrlEncode(string $input)
    {
        return str_replace('=', '', strtr(base64_encode($input), '+/', '-_'));
    }
}
