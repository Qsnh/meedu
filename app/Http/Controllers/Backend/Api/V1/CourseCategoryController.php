<?php

/*
 * This file is part of the Qsnh/meedu.
 *
 * (c) XiaoTeng <616896861@qq.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace App\Http\Controllers\Backend\Api\V1;

use App\Services\Course\Models\CourseCategory;
use App\Http\Requests\Backend\CourseCategoryRequest;

class CourseCategoryController extends BaseController
{
    public function index()
    {
        $navs = CourseCategory::orderByDesc('id')->paginate(12);

        return $this->successData($navs);
    }

    public function store(CourseCategoryRequest $request)
    {
        CourseCategory::create($request->filldata());

        return $this->success();
    }

    public function edit($id)
    {
        $info = CourseCategory::findOrFail($id);

        return $this->successData($info);
    }

    public function update(CourseCategoryRequest $request, $id)
    {
        $role = CourseCategory::findOrFail($id);
        $role->fill($request->filldata())->save();

        return $this->success();
    }

    public function destroy($id)
    {
        CourseCategory::destroy($id);

        return $this->success();
    }
}
