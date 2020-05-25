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
use App\Services\Member\Models\User;
use App\Services\Course\Models\Course;
use App\Services\Course\Models\CourseComment;

class CourseCommentController extends BaseController
{
    public function index(Request $request)
    {
        $courseId = $request->input('course_id');
        $comments = CourseComment::with(['course'])
            ->when($courseId, function ($query) use ($courseId) {
                $query->where('course_id', $courseId);
            })
            ->orderByDesc('id')
            ->paginate($request->input('size', 12));

        $userIds = [];
        foreach ($comments->items() as $item) {
            $userIds[] = $item->user_id;
        }
        $users = User::query()
            ->whereIn('id', array_flip(array_flip($userIds)))
            ->select(['id', 'nick_name', 'mobile', 'avatar'])
            ->get()
            ->keyBy('id');

        $courses = Course::query()->select(['id', 'title'])->get();

        return $this->successData([
            'data' => $comments,
            'courses' => $courses,
            'users' => $users,
        ]);
    }

    public function destroy(Request $request)
    {
        $ids = $request->input('ids');

        CourseComment::destroy($ids);

        return $this->success();
    }
}
