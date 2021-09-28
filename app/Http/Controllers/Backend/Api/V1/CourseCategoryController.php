<?php

/*
 * This file is part of the Qsnh/meedu.
 *
 * (c) 杭州白书科技有限公司
 */

namespace App\Http\Controllers\Backend\Api\V1;

use Illuminate\Http\Request;
use App\Services\Course\Models\Course;
use App\Services\Course\Models\CourseCategory;
use App\Http\Requests\Backend\CourseCategoryRequest;

class CourseCategoryController extends BaseController
{
    public function index(Request $request)
    {
        $data = CourseCategory::query()
            ->orderBy('sort')
            ->paginate($request->input('size', 10));

        return $this->successData($data);
    }

    public function store(CourseCategoryRequest $request)
    {
        CourseCategory::create($request->filldata());

        return $this->success();
    }

    public function edit($id)
    {
        $category = CourseCategory::query()->where('id', $id)->firstOrFail();

        return $this->successData($category);
    }

    public function update(CourseCategoryRequest $request, $id)
    {
        $category = CourseCategory::query()->where('id', $id)->firstOrFail();

        $category->fill($request->filldata())->save();

        return $this->success();
    }

    public function destroy($id)
    {
        if (Course::query()->where('category_id', $id)->exists()) {
            return $this->error(__('当前分类下存在课程，无法删除'));
        }

        CourseCategory::destroy($id);

        return $this->success();
    }
}
