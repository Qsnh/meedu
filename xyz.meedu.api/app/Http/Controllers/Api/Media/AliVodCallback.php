<?php

/*
 * This file is part of the MeEdu.
 *
 * (c) 杭州白书科技有限公司
 */

namespace App\Http\Controllers\Api\Media;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Events\AliyunVodCallbackTranscodeCompleteEvent;
use App\Events\AliyunVodCallbackFileUploadCompleteEvent;
use App\Meedu\ServiceV2\Services\ConfigServiceInterface;
use App\Events\AliyunVodCallbackVideoAnalysisCompleteEvent;
use App\Events\AliyunVodCallbackMediaBaseChangeCompleteEvent;

class AliVodCallback
{

    public function handler(Request $request, ConfigServiceInterface $configService)
    {
        $data = $request->all();
        $fullUrl = $request->fullUrl();
        $timestamp = $request->header('X-VOD-TIMESTAMP', '');
        $sign = $request->header('X-VOD-SIGNATURE', '');

        Log::info(__METHOD__, [
            '回调的数据' => $data,
            'headers' => compact('timestamp', 'sign'),
            'url' => $fullUrl,
        ]);

        if (!$data || !$timestamp || !$sign) {
            return response(__('参数错误'), 406);
        }

        $localSign = md5($fullUrl . '|' . $timestamp . '|' . $configService->getAliVodCallbackKey());
        if ($localSign !== strtoupper($sign)) {
            Log::error(__METHOD__ . '|非法的阿里云点播回调|sign:' . $localSign);
            return response(__('参数错误'), 406);
        }

        $status = $data['Status'] ?? '';
        $eventType = $data['EventType'] ?? '';
        $videoId = $data['VideoId'] ?? '';

        if ('success' === $status) {
            if ('MediaBaseChangeComplete' === $eventType) {
                $videoId = $data['MediaId'] ?? '';
                $mediaContent = $data['MediaContent'] ?? '';
                if ($videoId && $mediaContent) {
                    $mediaContent = json_decode($mediaContent, true);
                    $title = $mediaContent['NewValue'] ?? '';
                    if ($title) {
                        $title = explode('.', $title);
                        array_pop($title);
                        $title = implode('.', $title);

                        event(new AliyunVodCallbackMediaBaseChangeCompleteEvent($videoId, $title));
                    }
                }
            } elseif ('FileUploadComplete' === $eventType) {
                $size = $data['Size'] ?? 0;
                if ($size && $videoId) {
                    event(new AliyunVodCallbackFileUploadCompleteEvent($videoId, $size));
                }
            } elseif ('VideoAnalysisComplete' === $eventType) {
                $duration = $data['Duration'] ?? 0;
                $width = $data['Width'] ?? 0;
                $height = $data['Height'] ?? 0;
                if ($duration) {
                    event(new AliyunVodCallbackVideoAnalysisCompleteEvent($videoId, ceil($duration), compact('width', 'height')));
                }
            }
        }

        if ('TranscodeComplete' === $eventType) {
            $streamInfos = $data['StreamInfos'] ?? null;
            $streams = [];
            if ($streamInfos) {
                foreach ($streamInfos as $tmpItem) {
                    $streams[] = [
                        'status' => $tmpItem['Status'] ?? '',
                        'size' => $tmpItem['Size'] ?? 0,
                        'definition' => $tmpItem['Definition'] ?? '',
                        'encrypt' => $tmpItem['Encrypt'] ?? null,
                        'format' => $tmpItem['Format'] ?? '',
                        'start_time' => $tmpItem['StartTime'] ?? '',
                        'finish_time' => $tmpItem['FinishTime'] ?? '',
                        'height' => $tmpItem['Height'] ?? '',
                        'width' => $tmpItem['Width'] ?? '',
                        'job_id' => $tmpItem['JobId'] ?? '',
                    ];
                }
            }
            event(new AliyunVodCallbackTranscodeCompleteEvent($videoId, $status === 'success', $streams));
        }

        return 'success';
    }

}
