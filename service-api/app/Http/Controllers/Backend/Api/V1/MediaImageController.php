<?php

/*
 * This file is part of the MeEdu.
 *
 * (c) 杭州白书科技有限公司
 */

namespace App\Http\Controllers\Backend\Api\V1;

use App\Models\MediaImage;
use Illuminate\Http\Request;
use App\Models\AdministratorLog;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use App\Http\Requests\Backend\ImageUploadRequest;

class MediaImageController extends BaseController
{
    public function index(Request $request)
    {
        $from = (int)$request->input('from');

        $images = MediaImage::query()
            ->select(['id', 'from', 'url', 'path', 'disk', 'name', 'created_at'])
            ->when($from, function ($query) use ($from) {
                $query->where('from', $from);
            })
            ->orderByDesc('id')
            ->paginate($request->input('size'));

        AdministratorLog::storeLog(
            AdministratorLog::MODULE_ADMIN_MEDIA_IMAGE,
            AdministratorLog::OPT_VIEW,
            compact('from')
        );

        return $this->successData([
            'data' => [
                'data' => $images->items(),
                'total' => $images->total(),
            ],
            'from' => [
                [
                    'name' => __('全部'),
                    'key' => 0,
                ],
                [
                    'name' => __('编辑器'),
                    'key' => 1,
                ],
                [
                    'name' => __('直接上传'),
                    'key' => 2,
                ],
            ],
        ]);
    }

    public function upload(ImageUploadRequest $request)
    {
        $file = $request->filldata();
        $group = $request->input('group');
        $from = (int)$request->input('from');

        $imageGroup = 'admin' . ($group ? '-' . $group : '');

        $data = save_image($file, $imageGroup);

        $data = [
            'from' => $from,
            'name' => $data['name'],
            'url' => $data['url'],
            'path' => $data['path'],
            'disk' => $data['disk'],
        ];

        MediaImage::create($data);

        AdministratorLog::storeLog(
            AdministratorLog::MODULE_ADMIN_MEDIA_IMAGE,
            AdministratorLog::OPT_STORE,
            $data
        );

        return $this->successData($data);
    }

    public function destroy(Request $request)
    {
        $ids = $request->input('ids');
        if (!$ids || !is_array($ids)) {
            return $this->error(__('参数错误'));
        }

        $images = MediaImage::query()
            ->select(['id', 'disk', 'path'])
            ->whereIn('id', $ids)
            ->get();

        if ($images->isNotEmpty()) {
            foreach ($images as $imageItem) {
                $disk = $imageItem['disk'];
                $path = $imageItem['path'];

                try {
                    $imageItem->delete();
                    Storage::disk($imageItem['disk'])->delete($imageItem['path']);
                } catch (\Exception $e) {
                    Log::error(__METHOD__, ['msg' => $e->getMessage(), 'path' => $path, 'disk' => $disk]);
                }
            }
        }

        return $this->success();
    }
}
