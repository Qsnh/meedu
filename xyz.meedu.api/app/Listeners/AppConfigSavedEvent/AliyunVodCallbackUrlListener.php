<?php

/*
 * This file is part of the MeEdu.
 *
 * (c) 杭州白书科技有限公司
 */

namespace App\Listeners\AppConfigSavedEvent;

use App\Meedu\Aliyun\Vod;
use Illuminate\Support\Str;
use App\Constant\ConfigConstant;
use App\Events\AppConfigSavedEvent;
use Illuminate\Support\Facades\Log;
use App\Meedu\ServiceV2\Services\ConfigServiceInterface;

class AliyunVodCallbackUrlListener
{
    public $configService;

    public function __construct(ConfigServiceInterface $configService)
    {
        $this->configService = $configService;
    }

    /**
     * Handle the event.
     *
     * @param \App\Events\AppConfigSavedEvent $event
     * @return void
     */
    public function handle(AppConfigSavedEvent $event)
    {
        $config = $this->configService->getChunksConfigValues([
            ConfigConstant::APP_URL,
            ConfigConstant::ALIYUN_VOD_ACCESS_KEY_ID,
            ConfigConstant::ALIYUN_VOD_ACCESS_KEY_SECRET,
            ConfigConstant::ALIYUN_VOD_REGION,
            ConfigConstant::ALIYUN_VOD_HOST,
            ConfigConstant::ALIYUN_VOD_CALLBACK_KEY,
        ]);

        $appUrl = $config[ConfigConstant::APP_URL] ?? '';

        // 阿里云的点播配置
        $accessKeyId = $config[ConfigConstant::ALIYUN_VOD_ACCESS_KEY_ID] ?? '';
        $accessKeySecret = $config[ConfigConstant::ALIYUN_VOD_ACCESS_KEY_SECRET] ?? '';
        $region = $config[ConfigConstant::ALIYUN_VOD_REGION] ?? '';
        $host = $config[ConfigConstant::ALIYUN_VOD_HOST] ?? '';
        $callbackKey = $config[ConfigConstant::ALIYUN_VOD_CALLBACK_KEY] ?? '';

        if (!$accessKeyId || !$accessKeySecret || !$region || !$host) {
            Log::info(__METHOD__.'|阿里云点播配置不全=>不进行自动创建回调配置任务');
            return;
        }

        if (!$callbackKey) {
            Log::info(__METHOD__.'|ali-vod-callbackKey为空=>自动创建key并保存');
            $callbackKey = base64_decode('bWVlZHU=') . Str::random(24);
            $this->configService->updateAliyunVodCallbackKey($callbackKey);
        }

        // 查询最新的阿里云点播的回调配置
        $vod = new Vod([
            'region' => $region,
            'host' => $host,
            'access_key_id' => $accessKeyId,
            'access_key_secret' => $accessKeySecret,
        ]);

        $info = $vod->queryMessageCallback();
        if (false === $info) {
            return;
        }

        $callbackUrl = trim($appUrl, '/') . route('aliyun.vod.callback', null, false);

        if (
            // 回调地址不一样
            $info['callback_url'] !== $callbackUrl ||
            // 未开启鉴权
            !$info['is_enabled_auth_switch'] ||
            // 未开启HTTP回调方式
            !$info['is_http_callback_type'] ||
            // 未监听全部事件
            !$info['is_all_event'] ||
            // 鉴权的key不一致
            $info['auth_key'] !== $callbackKey
        ) {
            $vod->setMessageCallback($callbackUrl, $callbackKey);
        }
    }
}
