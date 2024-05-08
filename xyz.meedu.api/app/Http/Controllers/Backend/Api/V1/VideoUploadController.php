<?php

/*
 * This file is part of the MeEdu.
 *
 * (c) 杭州白书科技有限公司
 */

namespace App\Http\Controllers\Backend\Api\V1;

use Exception;
use Illuminate\Http\Request;
use App\Models\AdministratorLog;
use App\Services\Base\Interfaces\ConfigServiceInterface;

class VideoUploadController extends BaseController
{
    public function tencentToken()
    {
        $signature = app()->make(\App\Meedu\Tencent\Vod::class)->getUploadSignature();

        AdministratorLog::storeLog(
            AdministratorLog::MODULE_ADMIN_MEDIA_VIDEO,
            AdministratorLog::OPT_VIEW,
            []
        );

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

        try {
            aliyun_sdk_client();

            $config = $configService->getAliyunVodConfig();

            $result = \AlibabaCloud\Client\AlibabaCloud::rpc()
                ->host($config['host'])
                ->product('Vod')
                ->version('2017-03-21')
                ->action('CreateUploadVideo')
                ->options([
                    'query' => [
                        'Title' => $title,
                        'FileName' => $filename,
                    ]
                ])
                ->request();

            return $this->successData([
                'upload_auth' => $result['UploadAuth'],
                'upload_address' => $result['UploadAddress'],
                'video_id' => $result['VideoId'],
                'request_id' => $result['RequestId'],
            ]);
        } catch (Exception $exception) {
            exception_record($exception);

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

        try {
            aliyun_sdk_client();

            $config = $configService->getAliyunVodConfig();

            $result = \AlibabaCloud\Client\AlibabaCloud::rpc()
                ->product('Vod')
                ->host($config['host'])
                ->version('2017-03-21')
                ->action('RefreshUploadVideo')
                ->options([
                    'query' => [
                        'VideoId' => $videoId,
                    ]
                ])
                ->request();

            return $this->successData([
                'upload_auth' => $result['UploadAuth'],
                'upload_address' => $result['UploadAddress'],
                'video_id' => $result['VideoId'],
                'request_id' => $result['RequestId'],
            ]);
        } catch (Exception $exception) {
            exception_record($exception);

            return $this->error($exception->getMessage());
        }
    }
}
