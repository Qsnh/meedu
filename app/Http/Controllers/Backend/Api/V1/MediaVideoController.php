<?php

/*
 * This file is part of the MeEdu.
 *
 * (c) 杭州白书科技有限公司
 */

namespace App\Http\Controllers\Backend\Api\V1;

use App\Meedu\Aliyun\Vod;
use App\Meedu\Hooks\HookRun;
use Illuminate\Http\Request;
use App\Constant\HookConstant;
use App\Models\AdministratorLog;
use App\Events\VideoUploadedEvent;
use Illuminate\Support\Facades\DB;
use App\Services\Course\Models\MediaVideo;

class MediaVideoController extends BaseController
{
    public function index(Request $request)
    {
        $keywords = $request->input('keywords');
        $isOpen = (int)$request->input('is_open');

        $sort = strtolower($request->input('sort', 'id'));
        $order = strtolower($request->input('order', 'desc'));
        if (!in_array($sort, ['id', 'duration', 'size', 'created_at']) || !in_array($order, ['desc', 'asc'])) {
            return $this->error(__('排序参数错误'));
        }

        $records = MediaVideo::query()
            ->select([
                'id', 'title', 'thumb', 'duration', 'size', 'storage_driver', 'storage_file_id',
                'transcode_status', 'ref_count', 'created_at', 'updated_at',
            ])
            ->when($keywords, function ($query) use ($keywords) {
                $query->where('title', 'like', '%' . $keywords . '%');
            })
            ->when(in_array($isOpen, [0, 1]), function ($query) use ($isOpen) {
                $query->where('is_open', $isOpen);
            })
            ->orderByDesc('id')
            ->paginate($request->input('size', 10));

        $data = [
            'total' => $records->total(),
            'data' => $records->items(),
        ];

        $data = HookRun::mount(HookConstant::BACKEND_MEDIA_VIDEO_CONTROLLER_INDEX_RETURN_DATA, $data);

        AdministratorLog::storeLog(
            AdministratorLog::MODULE_ADMIN_MEDIA_VIDEO,
            AdministratorLog::OPT_VIEW,
            compact('keywords', 'isOpen')
        );

        return $this->successData($data);
    }

    public function store(Request $request)
    {
        $title = mb_substr(strip_tags($request->input('title', '')), 0, 255);
        $thumb = $request->input('thumb', '');
        $duration = (int)$request->input('duration');
        $size = (int)$request->input('size');
        $storageDriver = $request->input('storage_driver');
        $storageFileId = $request->input('storage_file_id');
        $isOpen = (int)$request->input('is_open');

        $data = [
            'title' => $title,
            'thumb' => $thumb,
            'duration' => $duration,
            'size' => $size,
            'storage_driver' => $storageDriver,
            'storage_file_id' => $storageFileId,
            'is_open' => $isOpen,
        ];

        $mediaVideo = MediaVideo::create($data);

        AdministratorLog::storeLog(
            AdministratorLog::MODULE_ADMIN_MEDIA_VIDEO,
            AdministratorLog::OPT_STORE,
            $data
        );

        event(new VideoUploadedEvent($storageFileId, $storageDriver, 'media_video', $mediaVideo['id']));

        return $this->successData($mediaVideo);
    }

    public function deleteVideos(Request $request, Vod $aliyunVod, \App\Meedu\Tencent\Vod $tencentVod)
    {
        $ids = $request->input('ids');
        if (!$ids || !is_array($ids)) {
            return $this->error(__('请选择需要删除的视频'));
        }

        AdministratorLog::storeLog(
            AdministratorLog::MODULE_ADMIN_MEDIA_VIDEO,
            AdministratorLog::OPT_DESTROY,
            compact('ids')
        );

        $videos = MediaVideo::query()->whereIn('id', $ids)->select(['id', 'storage_driver', 'storage_file_id'])->get();
        if ($videos->isEmpty()) {
            return $this->error(__('数据为空'));
        }

        $aliyunFileIds = [];
        $tencentFileIds = [];
        foreach ($videos as $videoItem) {
            if ($videoItem['storage_driver'] === 'aliyun') {
                $aliyunFileIds[] = $videoItem['storage_file_id'];
            } elseif ($videoItem['storage_driver'] === 'tencent') {
                $tencentFileIds[] = $videoItem['storage_file_id'];
            }
        }

        DB::transaction(function () use ($ids, $aliyunFileIds, $tencentFileIds, $aliyunVod, $tencentVod) {
            $aliyunFileIds && $aliyunVod->deleteVideos($aliyunFileIds);
            $tencentFileIds && $tencentVod->deleteVideos($tencentFileIds);

            MediaVideo::query()->whereIn('id', $ids)->delete();
        });

        return $this->successData();
    }
}
