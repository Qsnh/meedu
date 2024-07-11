<?php

/*
 * This file is part of the MeEdu.
 *
 * (c) 杭州白书科技有限公司
 */

namespace App\Http\Controllers\Backend\Api\V1;

use Exception;
use App\Meedu\Aliyun\Vod;
use Illuminate\Http\Request;
use App\Models\AdministratorLog;
use App\Bus\AliyunVodCallbackSyncBus;
use App\Bus\TencentVodCallbackSyncBus;
use App\Meedu\ServiceV2\Services\ConfigServiceInterface;

class VideoUploadController extends BaseController
{
    public function tencentToken(ConfigServiceInterface $configService)
    {
        AdministratorLog::storeLog(
            AdministratorLog::MODULE_ADMIN_MEDIA_VIDEO,
            AdministratorLog::OPT_VIEW,
            []
        );

        $vodConfig = $configService->getTencentVodConfig();

        if (!$vodConfig['app_id'] || !$vodConfig['secret_id'] || !$vodConfig['secret_key']) {
            return $this->error(__('腾讯云点播配置缺失'));
        }

        $bus = new TencentVodCallbackSyncBus();
        $bus->handler($vodConfig, true);

        $vod = new \App\Meedu\Tencent\Vod($vodConfig);

        $signature = $vod->getUploadSignature();

        return $this->successData(compact('signature'));
    }

    public function aliyunCreateVideoToken(Request $request, ConfigServiceInterface $configService)
    {
        $title = $request->input('title');
        $filename = $request->input('filename');

        AdministratorLog::storeLog(
            AdministratorLog::MODULE_ADMIN_MEDIA_VIDEO,
            AdministratorLog::OPT_VIEW,
            compact('title', 'filename')
        );

        if (!$title || !$filename) {
            return $this->error(__('参数错误'));
        }

        $vodConfig = $configService->getAliyunVodConfig();

        if (
            !$vodConfig['access_key_id'] ||
            !$vodConfig['access_key_secret'] ||
            !$vodConfig['region'] ||
            !$vodConfig['host']
        ) {
            return $this->error(__('阿里云点播配置缺失'));
        }

        try {
            (new AliyunVodCallbackSyncBus())->handler($vodConfig, true);

            $vod = new Vod($vodConfig);
            return $this->successData($vod->createUploadVideo($title, $filename));
        } catch (Exception $exception) {
            return $this->error($exception->getMessage());
        }
    }

    public function aliyunRefreshVideoToken(Request $request, ConfigServiceInterface $configService)
    {
        $videoId = $request->input('video_id');

        AdministratorLog::storeLog(
            AdministratorLog::MODULE_ADMIN_MEDIA_VIDEO,
            AdministratorLog::OPT_VIEW,
            compact('videoId')
        );

        if (!$videoId) {
            return $this->error(__('参数错误'));
        }

        $vodConfig = $configService->getAliyunVodConfig();

        if (
            !$vodConfig['access_key_id'] ||
            !$vodConfig['access_key_secret'] ||
            !$vodConfig['region'] ||
            !$vodConfig['host']
        ) {
            return $this->error(__('阿里云点播配置缺失'));
        }

        try {
            (new AliyunVodCallbackSyncBus())->handler($vodConfig, true);

            $vod = new Vod($vodConfig);
            return $this->successData($vod->refreshUploadVideo($videoId));
        } catch (Exception $exception) {
            return $this->error($exception->getMessage());
        }
    }
}
