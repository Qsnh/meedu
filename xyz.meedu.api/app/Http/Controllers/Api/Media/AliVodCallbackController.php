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
use App\Events\AliyunVodCallbackDeleteMediaCompleteEvent;
use App\Events\AliyunVodCallbackVideoAnalysisCompleteEvent;
use App\Events\AliyunVodCallbackMediaBaseChangeCompleteEvent;
use App\Events\AliyunVodCallbackAddLiveRecordVideoCompleteEvent;

class AliVodCallbackController
{

    public function handler(Request $request, ConfigServiceInterface $configService, $sign)
    {
        $data = $request->all();
        if (!$data) {
            return response(__('参数错误'), 406);
        }

        Log::info(__METHOD__, compact('data'));

        if ($sign !== $configService->getAliVodCallbackKey()) {
            Log::error(__METHOD__ . '|非法的阿里云点播回调|sign:' . $sign);
            return response(__('参数错误'), 406);
        }

        $status = $data['Status'] ?? '';
        $eventType = $data['EventType'] ?? '';
        $videoId = $data['VideoId'] ?? '';

        if ('success' === $status) {
            if ('MediaBaseChangeComplete' === $eventType) {
                $operateMode = $data['OperateMode'] ?? '';
                $videoId = $data['MediaId'] ?? '';
                $mediaContent = $data['MediaContent'] ?? '';
                if ($operateMode === 'create' && $videoId && $mediaContent) {
                    $mediaContent = json_decode($mediaContent['Title'], true);
                    $title = $mediaContent['NewValue'] ?? '';
                    if ($title) {
                        $title = explode('.', $title);
                        if (count($title) > 1) {
                            array_pop($title);
                        }
                        $title = implode('.', $title);

                        event(new AliyunVodCallbackMediaBaseChangeCompleteEvent($videoId, $title));
                    }
                }
            } elseif ('FileUploadComplete' === $eventType) {
                $size = $data['Size'] ?? 0;
                if ($size && $videoId) {
                    event(new AliyunVodCallbackFileUploadCompleteEvent($videoId, (int)$size));
                }
            } elseif ('VideoAnalysisComplete' === $eventType) {
                $duration = $data['Duration'] ?? 0;
                $width = $data['Width'] ?? 0;
                $height = $data['Height'] ?? 0;
                $size = $data['Size'] ?? 0;
                if ($duration) {
                    $duration = (int)$duration;//向下取整
                    event(
                        new AliyunVodCallbackVideoAnalysisCompleteEvent(
                            $videoId,
                            compact('width', 'height', 'duration', 'size')
                        )
                    );
                }
            } elseif ('DeleteMediaComplete' === $eventType) {
                $deleteType = $data['DeleteType'] ?? '';
                $videoId = $data['MediaId'] ?? '';
                if ('all' === $deleteType && $videoId) {
                    event(new AliyunVodCallbackDeleteMediaCompleteEvent($videoId));
                }
            } elseif ('AddLiveRecordVideoComplete' === $eventType) {
                $appName = $data['AppName'] ?? '';
                $streamName = $data['StreamName'] ?? '';
                $domainName = $data['DomainName'] ?? '';
                $recordStartTime = $data['RecordStartTime'] ?? '';
                $recordEndTime = $data['RecordEndTime'] ?? '';
                event(new AliyunVodCallbackAddLiveRecordVideoCompleteEvent(
                    $videoId,
                    $appName,
                    $streamName,
                    $domainName,
                    $recordStartTime,
                    $recordEndTime
                ));
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
