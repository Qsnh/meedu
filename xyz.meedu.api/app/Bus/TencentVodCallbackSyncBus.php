<?php

/*
 * This file is part of the MeEdu.
 *
 * (c) 杭州白书科技有限公司
 */

namespace App\Bus;

use App\Meedu\Tencent\Vod;
use Illuminate\Support\Str;
use App\Exceptions\ServiceException;
use App\Meedu\ServiceV2\Services\ConfigServiceInterface;

class TencentVodCallbackSyncBus
{

    public function handler(array $vodConfig, bool $throw = false)
    {
        if (
            !$vodConfig['app_id'] ||
            !$vodConfig['secret_id'] ||
            !$vodConfig['secret_key']
        ) {
            return;
        }

        /**
         * @var ConfigServiceInterface $configService
         */
        $configService = app()->make(ConfigServiceInterface::class);

        if(!$vodConfig['callback_key']) {
            $vodConfig['callback_key'] = base64_decode('TWVFZHUyMDIw=') . Str::random(20);
            $configService->updateTencentVodCallbackKey($vodConfig['callback_key']);
        }

        $callbackUrl = trim($configService->getApiUrl(), '/') . route('tencent.vod.callback', ['sign' => $vodConfig['callback_key']], false);

        $vod = new Vod($vodConfig);

        $callbackConfig = $vod->describeEventConfig();

        if (
            !$callbackConfig ||
            !$callbackConfig['is_http_mode'] ||
            !$callbackConfig['is_enabled_upload_media_complete'] ||
            !$callbackConfig['is_enabled_delete_media_complete'] ||
            $callbackConfig['notification_url'] !== $callbackUrl
        ) {
            $result = $vod->modifyEventConfig($callbackUrl);
            if (!$result) {
                throw new ServiceException(__('腾讯云点播回调配置失败'));
            }
        }
    }

}
