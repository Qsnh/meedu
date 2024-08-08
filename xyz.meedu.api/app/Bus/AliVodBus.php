<?php

/*
 * This file is part of the MeEdu.
 *
 * (c) 杭州白书科技有限公司
 */

namespace App\Bus;

use App\Meedu\Aliyun\Vod;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Log;
use App\Meedu\ServiceV2\Services\ConfigServiceInterface;

class AliVodBus
{

    private $accessKeyId;
    private $accessKeySecret;
    private $region;
    private $host;
    private $playDomain;
    private $playKey;
    private $callbackKey;

    private $vodLib;

    public function __construct(array $config)
    {
        // 必选参数
        $this->accessKeyId = $config['access_key_id'];
        $this->accessKeySecret = $config['access_key_secret'];
        $this->region = $config['region'];
        $this->host = $config['host'];

        // 可选参数
        isset($config['callback_key']) && $this->callbackKey = $config['callback_key'];
        isset($config['play_domain']) && $this->playDomain = $config['play_domain'];
        isset($config['play_key']) && $this->playKey = $config['play_key'];
    }

    public function getConfig(): array
    {
        return [
            'access_key_id' => $this->accessKeyId,
            'access_key_secret' => $this->accessKeySecret,
            'region' => $this->region,
            'host' => $this->host,
            'callback_key' => $this->callbackKey,
            'play_domain' => $this->playDomain,
            'play_key' => $this->playKey,
        ];
    }

    /**
     * @return Vod
     */
    public function getVodLib()
    {
        if (!$this->vodLib) {
            $this->vodLib = new Vod($this->getConfig());
        }
        return $this->vodLib;
    }

    public function playKeySync(): void
    {
        if (
            !$this->accessKeyId ||
            !$this->accessKeySecret ||
            'cn-shanghai' !== $this->region || //目前阿里云点播仅开放上海区域
            !$this->host ||
            !$this->playDomain
        ) {
            return;
        }

        /**
         * @var ConfigServiceInterface $configService
         */
        $configService = app()->make(ConfigServiceInterface::class);

        if (!$this->playKey) {
            $this->playKey = base64_decode('MjAyNE1FRUR1') . Str::random(20);
            $configService->updateAliyunVodPlayKey($this->playKey);
        }

        $vod = $this->getVodLib();

        try {
            $authConfig = $vod->describeVodDomainAuthConfig($this->playDomain);

            Log::info(__METHOD__ . '|阿里云playKey查询结果', $authConfig ? [
                'auth_type' => $authConfig['auth_type'],
                'auth_m3u8' => $authConfig['auth_m3u8'],
                'ali_auth_delta' => $authConfig['ali_auth_delta'],
                'auth_key1' => mb_substr($authConfig['auth_key1'], 0, 12) . '***' . mb_substr($authConfig['auth_key1'], -10, 10),
            ] : $authConfig);

            if (
                !$authConfig ||
                (
                    'type_a' !== $authConfig['auth_type'] ||
                    'on' !== $authConfig['auth_m3u8'] ||
                    (int)$authConfig['ali_auth_delta'] < 7200 ||
                    $this->playKey !== $authConfig['auth_key1']
                )
            ) {
                $vod->batchSetVodDomainAuthConfig($this->playDomain, $this->playKey);
            }
        } catch (\Exception $e) {
            Log::error(__METHOD__ . '|阿里云点播播放域名配置的playKey设置失败.错误信息:' . $e->getMessage(), ['play_domain' => $this->playDomain]);
        }
    }

    public function callbackKeySync($throw = false): void
    {
        if (
            !$this->accessKeyId ||
            !$this->accessKeySecret ||
            !$this->region ||
            !$this->host
        ) {
            return;
        }

        /**
         * @var ConfigServiceInterface $configService
         */
        $configService = app()->make(ConfigServiceInterface::class);

        if (!$this->callbackKey) {
            $this->callbackKey = base64_decode('TWVFZHUyMDIw=') . Str::random(20);
            $configService->updateAliyunVodCallbackKey($this->callbackKey);
        }

        $callbackUrl = trim($configService->getApiUrl(), '/') . route('aliyun.vod.callback', ['sign' => $this->callbackKey], false);

        $vod = $this->getVodLib();

        try {
            $callbackConfig = $vod->getMessageCallback();

            Log::info(__METHOD__ . '|阿里云callback查询结果', $callbackConfig ? [
                'auth_switch' => $callbackConfig['auth_switch'],
                'callback_type' => $callbackConfig['callback_type'],
                'event_type_list' => $callbackConfig['event_type_list'],
                'callback_url' => mb_substr($callbackConfig['callback_url'], 0, mb_strlen($callbackConfig['callback_url']) - 15) . '***' . mb_substr($callbackConfig['callback_url'], -8, 8),
            ] : $callbackConfig);

            if (
                !$callbackConfig ||
                (
                    // 回调地址不一样
                    $callbackConfig['callback_url'] !== $callbackUrl ||
                    // 开启鉴权
                    'on' === $callbackConfig['auth_switch'] ||
                    // 未开启HTTP回调方式
                    'HTTP' !== $callbackConfig['callback_type'] ||
                    // 未监听全部事件
                    'ALL' !== $callbackConfig['event_type_list']
                )
            ) {
                $vod->setMessageCallback($callbackUrl);
            }
        } catch (\Exception $e) {
            Log::error(__METHOD__ . '|阿里云callback设置失败.错误信息:' . $e->getMessage(), ['host' => $this->host, 'region' => $this->region]);
            throw_if($throw, $e);
        }
    }

}
