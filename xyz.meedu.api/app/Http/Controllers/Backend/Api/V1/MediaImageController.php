<?php

/*
 * This file is part of the MeEdu.
 *
 * (c) 杭州白书科技有限公司
 */

namespace App\Http\Controllers\Backend\Api\V1;

use App\Bus\UploadBus;
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
        $name = $request->input('name');
        $categoryId = max((int)$request->input('category_id'), 0);
        $scene = $request->input('scene');

        $images = MediaImage::query()
            ->select(['id', 'url', 'path', 'disk', 'name', 'created_at', 'category_id', 'scene'])
            ->when($name, function ($query) use ($name) {
                return $query->where('name', 'like', '%' . $name . '%');
            })
            ->when($categoryId, function ($query) use ($categoryId) {
                return $query->where('category_id', $categoryId);
            })
            ->when($scene, function ($query) use ($scene) {
                return $query->where('scene', $scene);
            })
            ->where('is_hide', 0)
            ->orderByDesc('id')
            ->paginate($request->input('size'));

        AdministratorLog::storeLog(
            AdministratorLog::MODULE_ADMIN_MEDIA_IMAGE,
            AdministratorLog::OPT_VIEW,
            compact('name', 'categoryId')
        );

        return $this->successData([
            'data' => $images->items(),
            'total' => $images->total(),
        ]);
    }

    public function upload(ImageUploadRequest $request, UploadBus $uploadBus)
    {
        ['file' => $file, 'scene' => $scene] = $request->filldata();

        if (!in_array($scene, UploadBus::SCENE_LIST)) {
            return $this->error(__('参数 $scene 的可选值有 :scene', ['scene' => implode(',', UploadBus::SCENE_LIST)]));
        }

        $administrator = $this->adminInfo();

        $data = $uploadBus->uploadFile2Public(
            $administrator['name'],
            sprintf('a-%d', $administrator['id']),
            $file,
            'meedu/images',
            $scene
        );

        AdministratorLog::storeLog(
            AdministratorLog::MODULE_ADMIN_MEDIA_IMAGE,
            AdministratorLog::OPT_STORE,
            [$data['media_image_id']]
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
