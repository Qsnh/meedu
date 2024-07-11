<?php

/*
 * This file is part of the MeEdu.
 *
 * (c) 杭州白书科技有限公司
 */

namespace App\Bus;

use App\Meedu\Aliyun\Vod;
use Illuminate\Support\Str;
use App\Exceptions\ServiceException;
use App\Meedu\ServiceV2\Services\ConfigServiceInterface;

class AliyunVodCallbackSyncBus
{

    public function handler(array $vodConfig, bool $throw = false)
    {
        if (
            !$vodConfig['access_key_id'] ||
            !$vodConfig['access_key_secret'] ||
            !$vodConfig['region'] ||
            !$vodConfig['host']
        ) {
            return;
        }

        /**
         * @var ConfigServiceInterface $configService
         */
        $configService = app()->make(ConfigServiceInterface::class);

        if (!$vodConfig['callback_key']) {
            $vodConfig['callback_key'] = base64_decode('TWVFZHUyMDIw=') . Str::random(20);
            $configService->updateAliyunVodCallbackKey($vodConfig['callback_key']);
        }

        $callbackUrl = trim($configService->getApiUrl(), '/') . route('aliyun.vod.callback', ['sign' => $vodConfig['callback_key']], false);

        $vod = new Vod($vodConfig);

        $callbackConfig = $vod->queryMessageCallback();

        if (
            !$callbackConfig ||
            (
                // 回调地址不一样
                $callbackConfig['callback_url'] !== $callbackUrl ||
                // 开启鉴权
                $callbackConfig['is_enabled_auth_switch'] ||
                // 未开启HTTP回调方式
                !$callbackConfig['is_http_callback_type'] ||
                // 未监听全部事件
                !$callbackConfig['is_all_event'] ||
                // 鉴权的key不一致
                $callbackConfig['auth_key'] !== $vodConfig['callback_key']
            )
        ) {
            $result = $vod->setMessageCallback($callbackUrl);

            if ($throw && !$result) {
                throw new ServiceException(__('阿里云点播回调设置失败'));
            }
        }
    }

}
