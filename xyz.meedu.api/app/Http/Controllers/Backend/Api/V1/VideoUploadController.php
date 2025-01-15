<?php

/*
 * This file is part of the MeEdu.
 *
 * (c) 杭州白书科技有限公司
 */

namespace App\Http\Controllers\Backend\Api\V1;

use Exception;
use App\Bus\AliVodBus;
use App\Bus\TencentVodBus;
use Illuminate\Http\Request;
use App\Models\AdministratorLog;
use App\Bus\MediaVideoCategoryBindBus;
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

        $tencentVodBus = new TencentVodBus($vodConfig);

        $tencentVodBus->callbackSync(true);

        $signature = $tencentVodBus->getVodLib()->getUploadSignature();

        return $this->successData(compact('signature'));
    }

    public function aliyunCreateVideoToken(Request $request, ConfigServiceInterface $configService, MediaVideoCategoryBindBus $mediaVideoCategoryBindBus)
    {
        $title = $request->input('title');
        $filename = $request->input('filename');
        $categoryId = (int)$request->input('category_id');

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
            $aliVodBus = new AliVodBus($vodConfig);

            $aliVodBus->callbackKeySync(true);

            $data = $aliVodBus->getVodLib()->createUploadVideo($title, $filename);

            $categoryId && $mediaVideoCategoryBindBus->setCache($data['video_id'], $categoryId);

            return $this->successData($data);
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
            $aliVodBus = new AliVodBus($vodConfig);

            return $this->successData($aliVodBus->getVodLib()->refreshUploadVideo($videoId));
        } catch (Exception $exception) {
            return $this->error($exception->getMessage());
        }
    }
}
