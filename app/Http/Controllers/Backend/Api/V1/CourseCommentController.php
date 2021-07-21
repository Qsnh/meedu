<?php

/*
 * This file is part of the Qsnh/meedu.
 *
 * (c) 杭州白书科技有限公司
 */

namespace App\Http\Controllers\Backend\Api\V1;

use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Services\Member\Models\User;
use App\Services\Course\Models\CourseComment;

class CourseCommentController extends BaseController
{
    public function index(Request $request)
    {
        $courseId = $request->input('course_id');
        $userId = $request->input('user_id');
        $createdAt = $request->input('created_at');

        $comments = CourseComment::query()
            ->with(['course:id,title,charge,thumb'])
            ->when($courseId, function ($query) use ($courseId) {
                $query->where('course_id', $courseId);
            })
            ->when($userId, function ($query) use ($userId) {
                $query->where('user_id', $userId);
            })
            ->when($createdAt && is_array($createdAt), function ($query) use ($createdAt) {
                $query->whereBetween('created_at', [Carbon::parse($createdAt[0]), Carbon::parse($createdAt[1])]);
            })
            ->orderByDesc('id')
            ->paginate($request->input('size', 10));

        $users = User::query()
            ->whereIn('id', array_column($comments->items(), 'user_id'))
            ->select(['id', 'nick_name', 'mobile', 'avatar'])
            ->get()
            ->keyBy('id');

        return $this->successData([
            'data' => $comments,
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
