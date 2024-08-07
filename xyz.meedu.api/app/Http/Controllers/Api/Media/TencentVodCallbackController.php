<?php

/*
 * This file is part of the MeEdu.
 *
 * (c) 杭州白书科技有限公司
 */

namespace App\Http\Controllers\Api\Media;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Events\TencentVodCallbackFileDeletedEvent;
use App\Events\TencentVodCallbackNewFileUploadEvent;
use App\Events\TencentVodCallbackTranscodeCompleteEvent;
use App\Meedu\ServiceV2\Services\ConfigServiceInterface;
use App\Events\TencentVodCallbackProcedureStateChangedEvent;

class TencentVodCallbackController
{

    public function handler(Request $request, ConfigServiceInterface $configService, $sign)
    {
        $data = $request->all();
        if (!$data) {
            return response(__('参数错误'), 406);
        }

        Log::info(__METHOD__, compact('data'));

        if ($sign !== $configService->getTencentVodCallbackKey()) {
            Log::error(__METHOD__ . '|非法的阿里云点播回调|sign:' . $sign);
            return response(__('参数错误'), 406);
        }

        $eventType = $data['EventType'] ?? '';

        if ('NewFileUpload' === $eventType) {
            $eventInfo = $data['FileUploadEvent'] ?? null;
            if ($eventInfo) {
                $videoId = $eventInfo['FileId'] ?? null;
                $basicInfo = $eventInfo['MediaBasicInfo'] ?? null;
                $metaData = $eventInfo['MetaData'] ?? null;
                if ($videoId && $basicInfo && $metaData) {
                    $name = $basicInfo['Name'] ?? null;
                    $size = $metaData['Size'] ?? 0;
                    $duration = (int)($metaData['Duration'] ?? 0);

                    if ($name && $size && $duration) {
                        $duration = ceil($duration);

                        event(new TencentVodCallbackNewFileUploadEvent($videoId, [
                            'title' => $name,
                            'size' => $size,
                            'duration' => $duration,
                        ]));
                    }
                }
            }
        } elseif ('FileDeleted' === $eventType) {
            $eventInfo = $data['FileDeleteEvent'] ?? null;
            if ($eventInfo) {
                $fileIdSet = $eventInfo['FileIdSet'] ?? null;
                if ($fileIdSet) {
                    event(new TencentVodCallbackFileDeletedEvent($fileIdSet));
                }
            }
        } elseif ('TranscodeComplete' === $eventType) {
            $eventInfo = $data['TranscodeComplete'] ?? null;
            if ($eventInfo) {
                $taskId = $eventInfo['TaskId'] ?? null;
                $message = $eventInfo['Message'] ?? null;
                $videoId = $eventInfo['FileId'] ?? null;
                $playInfoSet = $eventInfo['PlayInfoSet'] ?? [];
                if ($taskId && $message && $videoId) {
                    event(new TencentVodCallbackTranscodeCompleteEvent($videoId, $taskId, $message, $playInfoSet));
                }
            }
        } elseif ('ProcedureStateChanged' === $eventType) {
            $eventInfo = $data['ProcedureStateChangedEvent'] ?? null;
            if ($eventInfo) {
                $taskId = $eventInfo['TaskId'] ?? null;
                $message = $eventInfo['Message'] ?? null;
                $videoId = $eventInfo['FileId'] ?? null;
                $status = $eventInfo['Status'] ?? null;
                $resultSet = $eventInfo['MediaProcessResultSet'] ?? [];

                if ($taskId && $message && $videoId && $status) {
                    event(new TencentVodCallbackProcedureStateChangedEvent($videoId, $taskId, $message, $status, $resultSet));
                }
            }
        }

        return 'success';
    }

}
