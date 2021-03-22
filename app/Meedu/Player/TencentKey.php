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
use App\Services\Base\Services\ConfigService;
use App\Services\Base\Interfaces\ConfigServiceInterface;

class TencentKey
{
    protected $appId;

    protected $key;

    protected $pcfg;

    public function __construct()
    {
        /**
         * @var ConfigService $configService
         */
        $configService = app()->make(ConfigServiceInterface::class);

        $tencentVodConfig = $configService->getTencentVodConfig();
        $this->appId = $tencentVodConfig['app_id'];

        $config = $configService->getPlayer();
        $this->key = $config['tencent_play_key'] ?? '';
        $this->pcfg = $config['tencent_pcfg'] ?? '';
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
        $t = time() + 3600 * 3;
        // 试看[不少于30s]
        $exper = $isTry ? ($video['free_seconds'] ?? 0) : 0;
        // ip限制[1个]
        $rlimit = 1;
        // 标识符
        $us = Str::random(6);

        // 生成签名
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
            'appId' => (int)$this->appId,
            'fileId' => $video['tencent_video_id'],
            // 链接生成时间
            'currentTimeStamp' => time(),
            // 链接到期时间[3小时]
            'expireTimeStamp' => time() + 3600 * 3,
            'urlAccessInfo' => [
                // 仅允许一个ip访问
                'rlimit' => 1,
                // 标识符
                'us' => Str::random(6),
                // 试看[不小于30s]
                'exper' => $isTry ? (int)($video['free_seconds'] ?? 0) : 0,
            ],
            // 播放自适应的码流
            'pcfg' => $this->pcfg,
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
