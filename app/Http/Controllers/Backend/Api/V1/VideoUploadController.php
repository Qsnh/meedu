<?php

/*
 * This file is part of the Qsnh/meedu.
 *
 * (c) XiaoTeng <616896861@qq.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace App\Http\Controllers\Backend\Api\V1;

use Exception;
use Illuminate\Http\Request;

class VideoUploadController extends BaseController
{
    public function tencentToken()
    {
        $signature = app()->make(\App\Meedu\Tencent\Vod::class)->getUploadSignature();

        return $this->successData(compact('signature'));
    }

    public function aliyunCreateVideoToken(Request $request)
    {
        $title = $request->input('title');
        $filename = $request->input('filename');

        try {
            aliyun_sdk_client();

            $result = \AlibabaCloud\Client\AlibabaCloud::rpc()
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

    public function aliyunRefreshVideoToken(Request $request)
    {
        $videoId = $request->input('video_id');

        try {
            aliyun_sdk_client();

            $result = \AlibabaCloud\Client\AlibabaCloud::rpc()
                ->product('Vod')
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
