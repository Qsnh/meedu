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
use vod\Request\V20170321 as vod;

class AliyunVideoUploadController extends BaseController
{
    public function createVideoToken(Request $request)
    {
        try {
            $title = $request->input('title');
            $filename = $request->input('filename');
            $client = aliyun_sdk_client();
            $request = new vod\CreateUploadVideoRequest();
            $request->setTitle($title);
            $request->setFileName($filename);
            $response = $client->getAcsResponse($request);

            return [
                'upload_auth' => $response->UploadAuth,
                'upload_address' => $response->UploadAddress,
                'video_id' => $response->VideoId,
                'request_id' => $response->RequestId,
            ];
        } catch (Exception $exception) {
            exception_record($exception);

            return $this->error($exception->getMessage());
        }
    }

    public function refreshVideoToken(Request $request)
    {
        try {
            $videoId = $request->input('video_id');
            $client = aliyun_sdk_client();
            $request = new vod\RefreshUploadVideoRequest();
            $request->setVideoId($videoId);
            $response = $client->getAcsResponse($request);

            return [
                'upload_auth' => $response->UploadAuth,
                'upload_address' => $response->UploadAddress,
                'video_id' => $response->VideoId,
                'request_id' => $response->RequestId,
            ];
        } catch (Exception $exception) {
            exception_record($exception);

            return $this->error($exception->getMessage());
        }
    }
}
