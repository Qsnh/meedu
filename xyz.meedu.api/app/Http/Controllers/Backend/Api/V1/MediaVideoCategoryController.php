<?php

/*
 * This file is part of the MeEdu.
 *
 * (c) 杭州白书科技有限公司
 */

namespace App\Http\Controllers\Backend\Api\V1;

use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Models\MediaVideoCategory;
use Illuminate\Support\Facades\DB;
use App\Meedu\ServiceV2\Models\MediaVideo;
use App\Http\Requests\Backend\MediaVideoCategoryRequest;

class MediaVideoCategoryController extends BaseController
{

    public function index()
    {
        $categories = MediaVideoCategory::query()->orderBy('sort')->get()->groupBy('parent_id')->toArray();

        return $this->successData([
            'data' => $categories,
        ]);
    }

    public function create()
    {
        $categories = MediaVideoCategory::query()->orderBy('sort')->get()->groupBy('parent_id')->toArray();

        return $this->successData([
            'categories' => $categories,
        ]);
    }

    public function store(MediaVideoCategoryRequest $request)
    {
        $data = $request->filldata();
        $data['admin_id'] = $this->adminId();

        if ($data['parent_id']) {
            $parentItem = MediaVideoCategory::query()->where('id', $data['parent_id'])->first();
            if (!$parentItem) {
                return $this->error(__('父级分类不存在'));
            }
            $data['parent_chain'] = ($parentItem['parent_chain'] ?? '') . ',' . $parentItem['id'];
            if (Str::startsWith($data['parent_chain'], '0,')) {
                $data['parent_chain'] = Str::after($data['parent_chain'], '0,');
            }
        }

        MediaVideoCategory::create($data);

        return $this->success();
    }

    public function edit($id)
    {
        $category = MediaVideoCategory::query()->where('id', $id)->firstOrFail();
        return $this->successData(['category' => $category]);
    }

    public function update(MediaVideoCategoryRequest $request, $id)
    {
        $category = MediaVideoCategory::query()->where('id', $id)->firstOrFail();
        $data = $request->filldata();

        if ($data['parent_id'] !== $category['parent_id']) {
            if ($data['parent_id'] === 0) {
                $data['parent_chain'] = '';
            } else {
                $parentItem = MediaVideoCategory::query()->where('id', $data['parent_id'])->first();
                if (!$parentItem) {
                    return $this->error(__('父级分类不存在'));
                }
                $data['parent_chain'] = ($parentItem['parent_chain'] ?? '') . ',' . $parentItem['id'];
                if (Str::startsWith($data['parent_chain'], '0,')) {
                    $data['parent_chain'] = Str::after($data['parent_chain'], '0,');
                }
            }
        }

        $category->fill($data)->save();

        return $this->success();
    }

    public function destroy($id)
    {
        $category = MediaVideoCategory::query()->where('id', $id)->firstOrFail();

        if (MediaVideoCategory::query()->where('parent_id', $category['id'])->exists()) {
            return $this->error(__('当前分类存在子分类!'));
        }

        if (MediaVideo::query()->where('category_id', $category['id'])->exists()) {
            return $this->error(__('当前分类下存在视频!'));
        }

        $category->delete();

        return $this->success();
    }

    public function changeSort(Request $request)
    {
        $ids = $request->input('ids');
        if (!$ids) {
            return $this->error(__('参数错误'));
        }

        $parentIds = MediaVideoCategory::query()->whereIn('id', $ids)->pluck('parent_id')->unique()->toArray();
        if (count($parentIds) > 1) {
            return $this->error(__('非同级分类'));
        }

        for ($i = 0; $i < count($ids); $i++) {
            MediaVideoCategory::query()->where('id', $ids[$i])->update(['sort' => $i]);
        }

        return $this->success();
    }

    public function changeParent(Request $request)
    {
        $id = max((int)$request->input('id'), 0);
        $parentId = max((int)$request->input('parent_id'), 0);
        $ids = $request->input('ids');
        if (!$id || !$ids) {
            return $this->error(__('参数错误'));
        }

        DB::transaction(function () use ($ids, $parentId, $id) {
            $category = MediaVideoCategory::query()->where('id', $id)->firstOrFail();

            $updateDATA = [
                'parent_id' => $parentId,
                'parent_chain' => '',
            ];

            if ($updateDATA['parent_id'] !== 0) {
                $parentItem = MediaVideoCategory::query()->where('id', $updateDATA['parent_id'])->first();
                if (!$parentItem) {
                    return $this->error(__('父级分类不存在'));
                }
                $updateDATA['parent_chain'] = ($parentItem['parent_chain'] ?? '') . ',' . $parentItem['id'];
                if (Str::startsWith($updateDATA['parent_chain'], '0,')) {
                    $updateDATA['parent_chain'] = Str::after($updateDATA['parent_chain'], '0,');
                }
            }

            $category->fill($updateDATA)->save();

            // 排序更新
            for ($i = 0; $i < count($ids); $i++) {
                MediaVideoCategory::query()->where('id', $ids[$i])->update(['sort' => $i]);
            }
        });

        return $this->success();
    }

}
