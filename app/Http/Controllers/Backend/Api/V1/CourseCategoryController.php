<?php

/*
 * This file is part of the Qsnh/meedu.
 *
 * (c) 杭州白书科技有限公司
 */

namespace App\Http\Controllers\Backend\Api\V1;

use Illuminate\Support\Arr;
use Illuminate\Http\Request;
use App\Models\AdministratorLog;
use App\Services\Course\Models\Course;
use App\Services\Course\Models\CourseCategory;
use App\Http\Requests\Backend\CourseCategoryRequest;

class CourseCategoryController extends BaseController
{
    public function index(Request $request)
    {
        $data = CourseCategory::query()
            ->select(['id', 'sort', 'name', 'parent_id'])
            ->where('parent_id', 0)
            ->orderBy('sort')
            ->paginate($request->input('size', 10));

        $total = $data->total();
        $data = $data->items();

        $children = CourseCategory::query()
            ->select(['id', 'sort', 'name', 'parent_id'])
            ->whereIn('parent_id', array_column($data, 'id'))
            ->orderBy('sort')
            ->get()
            ->groupBy('parent_id')
            ->toArray();

        foreach ($data as $key => $item) {
            $data[$key]['children'] = $children[$item['id']] ?? [];
        }

        AdministratorLog::storeLog(
            AdministratorLog::MODULE_VOD_CATEGORY,
            AdministratorLog::OPT_VIEW,
            []
        );

        return $this->successData([
            'data' => $data,
            'total' => $total,
        ]);
    }

    public function create()
    {
        $categories = CourseCategory::query()
            ->where('parent_id', 0)
            ->orderBy('sort')
            ->get();

        return $this->successData(compact('categories'));
    }

    public function store(CourseCategoryRequest $request)
    {
        $data = $request->filldata();

        $category = CourseCategory::create($data);

        AdministratorLog::storeLog(
            AdministratorLog::MODULE_VOD_CATEGORY,
            AdministratorLog::OPT_STORE,
            Arr::only($category->toArray(), ['id', 'sort', 'name', 'parent_id', 'parent_chain', 'is_show'])
        );

        return $this->success();
    }

    public function edit($id)
    {
        $category = CourseCategory::query()->where('id', $id)->firstOrFail();

        AdministratorLog::storeLog(
            AdministratorLog::MODULE_VOD_CATEGORY,
            AdministratorLog::OPT_VIEW,
            compact('id')
        );

        return $this->successData($category);
    }

    public function update(CourseCategoryRequest $request, $id)
    {
        $data = $request->filldata();
        $category = CourseCategory::query()->where('id', $id)->firstOrFail();

        AdministratorLog::storeLogDiff(
            AdministratorLog::MODULE_VOD_CATEGORY,
            AdministratorLog::OPT_UPDATE,
            Arr::only($data, ['sort', 'name', 'parent_id', 'parent_chain', 'is_show']),
            Arr::only($category->toArray(), ['sort', 'name', 'parent_id', 'parent_chain', 'is_show'])
        );

        $category->fill($data)->save();

        return $this->success();
    }

    public function destroy($id)
    {
        if (CourseCategory::query()->where('parent_id', $id)->exists()) {
            return $this->error('该分类下存在子分类，无法删除');
        }

        if (Course::query()->where('category_id', $id)->exists()) {
            return $this->error(__('当前分类下存在课程，无法删除'));
        }

        CourseCategory::destroy($id);

        AdministratorLog::storeLog(
            AdministratorLog::MODULE_VOD_CATEGORY,
            AdministratorLog::OPT_DESTROY,
            compact('id')
        );

        return $this->success();
    }
}
