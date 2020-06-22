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

use Illuminate\Http\Request;
use App\Services\Course\Models\Course;
use App\Services\Course\Models\CourseAttach;
use App\Http\Requests\Backend\CourseAttachRequest;

class CourseAttachController extends BaseController
{
    public function index(Request $request)
    {
        $courseId = $request->input('course_id');
        $course = Course::query()->where('id', $courseId)->firstOrFail();
        $attach = CourseAttach::query()->where('course_id', $courseId)->get();
        return $this->successData([
            'data' => $attach,
            'course' => $course,
        ]);
    }

    public function store(CourseAttachRequest $request)
    {
        $data = $request->filldata();
        CourseAttach::create($data);
        return $this->success();
    }

    public function destroy($id)
    {
        $attach = CourseAttach::query()->where('id', $id)->firstOrFail();
        $attach->delete();
        return $this->success();
    }
}
