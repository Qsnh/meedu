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
use App\Models\MediaVideoCategory;
use Illuminate\Support\Facades\DB;
use App\Bus\MediaVideoCategoryBindBus;
use App\Meedu\ServiceV2\Models\MediaVideo;
use App\Meedu\ServiceV2\Services\ConfigServiceInterface;

class MediaVideoController extends BaseController
{
    public function index(Request $request)
    {
        $keywords = $request->input('keywords');
        $isOpen = (int)$request->input('is_open');
        $categoryId = (int)$request->input('category_id');

        $sort = strtolower($request->input('sort', 'id'));
        $order = strtolower($request->input('order', 'desc'));

        AdministratorLog::storeLog(
            AdministratorLog::MODULE_ADMIN_MEDIA_VIDEO,
            AdministratorLog::OPT_VIEW,
            compact('keywords', 'isOpen', 'sort', 'order')
        );

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
            ->when($categoryId !== -1, function ($query) use ($categoryId) {
                if (0 === $categoryId) {
                    $query->where('category_id', $categoryId);
                } else {
                    $category = MediaVideoCategory::query()->where('id', $categoryId)->first();
                    if ($category) {
                        $tmpChain = $category['parent_chain'] ? $category['parent_chain'] . ',' . $category['id'] : $category['id'];
                        $childrenIds = MediaVideoCategory::query()->where('parent_chain', 'like', $tmpChain)->get()->pluck('id')->toArray();
                        $childrenIds[] = $category['id'];
                        $query->whereIn('category_id', $childrenIds);
                    }
                }
            })
            ->where('is_hidden', 0)
            ->orderByDesc('id')
            ->paginate($request->input('size', 10));

        $data = [
            'total' => $records->total(),
            'data' => $records->items(),
        ];

        $data = HookRun::mount(HookConstant::BACKEND_MEDIA_VIDEO_CONTROLLER_INDEX_RETURN_DATA, $data);

        return $this->successData($data);
    }

    public function deleteVideos(Request $request, ConfigServiceInterface $configService)
    {
        $ids = $request->input('ids');

        AdministratorLog::storeLog(
            AdministratorLog::MODULE_ADMIN_MEDIA_VIDEO,
            AdministratorLog::OPT_DESTROY,
            compact('ids')
        );

        if (!$ids || !is_array($ids)) {
            return $this->error(__('请选择需要删除的视频'));
        }

        $videos = MediaVideo::query()->whereIn('id', $ids)->select(['id', 'storage_driver', 'storage_file_id'])->get();
        if ($videos->isEmpty()) {
            return $this->error(__('数据为空'));
        }

        $aliFileIds = [];
        $tencentFileIds = [];
        foreach ($videos as $videoItem) {
            if ($videoItem['storage_driver'] === 'aliyun') {
                $aliFileIds[] = $videoItem['storage_file_id'];
            } elseif ($videoItem['storage_driver'] === 'tencent') {
                $tencentFileIds[] = $videoItem['storage_file_id'];
            }
        }

        $aliVod = new Vod($configService->getAliyunVodConfig());
        $tencentVod = new \App\Meedu\Tencent\Vod($configService->getTencentVodConfig());

        DB::transaction(function () use ($ids, $aliFileIds, $tencentFileIds, $aliVod, $tencentVod) {
            $aliFileIds && $aliVod->deleteVideos($aliFileIds);
            $tencentFileIds && $tencentVod->deleteVideos($tencentFileIds);

            MediaVideo::query()->whereIn('id', $ids)->delete();
        });

        return $this->successData();
    }

    public function changeCategory(Request $request)
    {
        $ids = $request->input('ids');
        $categoryId = max((int)$request->input('category_id'), 0);
        if (!$ids || !is_array($ids) || !$categoryId) {
            return $this->error(__('参数错误'));
        }

        MediaVideo::query()
            ->whereIn('id', $ids)
            ->update(['category_id' => $categoryId]);

        return $this->success();
    }

    public function recordCategoryId(Request $request, MediaVideoCategoryBindBus $mediaVideoCategoryBindBus)
    {
        $videoId = $request->input('video_id');
        $categoryId = max(0, (int)$request->input('category_id'));
        if (!$videoId) {
            return $this->error(__('参数错误'));
        }

        $mediaVideoCategoryBindBus->setCache($videoId, $categoryId);

        // 如果本地存在记录的话，那么直接修改所属分类
        $record = MediaVideo::query()->where('storage_file_id')->first();
        if ($record) {
            $record->fill(['category_id' => $categoryId])->save();
            // 删除缓存
            $mediaVideoCategoryBindBus->remove($videoId);
        }

        return $this->success();
    }
}
