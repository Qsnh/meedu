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
use App\Meedu\ServiceV2\Services\ConfigServiceInterface;

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
                    $duration = $metaData['Duration'] ?? 0;

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
        }

        return 'success';
    }

}
