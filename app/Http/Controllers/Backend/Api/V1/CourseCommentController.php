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
use App\Models\CourseComment;
use App\Services\Course\Models\Course;

class CourseCommentController extends BaseController
{
    public function index(Request $request)
    {
        $courseId = $request->input('course_id');
        $comments = CourseComment::with(['user', 'course'])
            ->when($courseId, function ($query) use ($courseId) {
                $query->where('course_id', $courseId);
            })
            ->orderByDesc('id')
            ->paginate($request->input('size', 12));

        $courses = Course::query()->select(['id', 'title'])->get();

        return $this->successData([
            'data' => $comments,
            'courses' => $courses,
        ]);
    }

    public function destroy($id)
    {
        CourseComment::destroy($id);

        return $this->success();
    }
}
