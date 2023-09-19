<?php

/*
 * This file is part of the MeEdu.
 *
 * (c) 杭州白书科技有限公司
 */

namespace App\Meedu\Player;

use Illuminate\Support\Str;
use App\Services\Base\Interfaces\ConfigServiceInterface;

class TencentKey
{
    // AppId
    protected $appId;
    // 播放key
    protected $key;

    public function __construct(ConfigServiceInterface $configService)
    {
        $tencentVodConfig = $configService->getTencentVodConfig();
        $this->appId = $tencentVodConfig['app_id'];
        $this->key = $configService->getTencentVodPlayKey();
    }

    /**
     * 播放URL签名
     *
     * @param $url
     * @param mixed $isTry
     * @param array $video
     * @return string
     */
    public function url($url, $isTry = false, array $video = [])
    {
        if (!$this->key) {
            // 未配置key无法签名
            return $url;
        }

        $urlInfo = parse_url($url);
        $dir = pathinfo($urlInfo['path'], PATHINFO_DIRNAME) . '/';
        // 默认三个小时
        $t = time() + 3600 * 3;
        // 试看逻辑
        $exper = 0;
        if ($isTry && $freeSeconds = ($video['free_seconds'] ?? 0)) {
            // 试看时间不能小于30s
            $exper = $freeSeconds >= 30 ? $freeSeconds : 30;
        };
        // ip限制[1个]
        $rlimit = 1;
        // 标识符
        $us = Str::random(6);

        // 生成签名
        $sign = md5($this->key . $dir . $t . $exper . $rlimit . $us);
        return sprintf('%s?t=%s&exper=%d&rlimit=%d&us=%s&sign=%s', $url, $t, $exper, $rlimit, $us, $sign);
    }

    /**
     * 获取播放签名
     *
     * @param array $video
     * @param false $isTry
     * @return string
     */
    public function psign(array $video, $isTry = false): string
    {
        if (!$this->key) {
            return '';
        }
        $header = [
            'alg' => 'HS256',
            'typ' => 'JWT',
        ];
        $now = time();
        // 试看逻辑
        $trySeeSeconds = 0;
        if ($isTry && $freeSeconds = ($video['free_seconds'] ?? 0)) {
            // 试看时间不能小于30s
            $trySeeSeconds = $freeSeconds >= 30 ? $freeSeconds : 30;
        }
        // 加密参数
        $data = [
            'appId' => (int)$this->appId,
            'fileId' => $video['tencent_video_id'],
            'currentTimeStamp' => $now,
            'expireTimeStamp' => $now + 3600 * 3, //3小时
            'urlAccessInfo' => [
                'rlimit' => 1,//仅允许1个ip访问
                'us' => Str::random(6),//随机字符串
                'exper' => $trySeeSeconds, //试看秒数
            ],
        ];
        $headerEncode = $this->base64UrlEncode(json_encode($header, JSON_UNESCAPED_UNICODE));
        $dataEncode = $this->base64UrlEncode(json_encode($data, JSON_UNESCAPED_UNICODE));
        $sign = $this->base64UrlEncode(hash_hmac('sha256', $headerEncode . '.' . $dataEncode, $this->key, true));
        return $headerEncode . '.' . $dataEncode . '.' . $sign;
    }

    private function base64UrlEncode(string $input)
    {
        return str_replace('=', '', strtr(base64_encode($input), '+/', '-_'));
    }
}
