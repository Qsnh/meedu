<?php

/*
 * This file is part of the MeEdu.
 *
 * (c) 杭州白书科技有限公司
 */

namespace App\Http\Controllers\Backend\Api\V1;

use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Models\AdministratorLog;
use App\Services\Member\Models\User;
use App\Services\Course\Models\CourseComment;

class CourseCommentController extends BaseController
{
    public function index(Request $request)
    {
        $courseId = (int)$request->input('course_id');
        $userId = (int)$request->input('user_id');
        $createdAt = $request->input('created_at');
        $isCheck = (int)$request->input('is_check');

        if ($createdAt && !is_array($createdAt)) {
            return $this->error(__('参数错误'));
        }

        AdministratorLog::storeLog(
            AdministratorLog::MODULE_VOD_COMMENT,
            AdministratorLog::OPT_VIEW,
            compact('courseId', 'userId', 'createdAt')
        );

        $comments = CourseComment::query()
            ->with(['course:id,title,charge,thumb'])
            ->when($courseId, function ($query) use ($courseId) {
                $query->where('course_id', $courseId);
            })
            ->when($userId, function ($query) use ($userId) {
                $query->where('user_id', $userId);
            })
            ->when($createdAt, function ($query) use ($createdAt) {
                $query->whereBetween('created_at', [
                    Carbon::parse($createdAt[0])->toDateTimeLocalString(),
                    Carbon::parse($createdAt[1])->toDateTimeLocalString(),
                ]);
            })
            ->when(in_array($isCheck, [0, 1]), function ($query) use ($isCheck) {
                $query->where('is_check', $isCheck);
            })
            ->orderByDesc('id')
            ->paginate($request->input('size', 10));

        $users = User::query()
            ->whereIn('id', array_column($comments->items(), 'user_id'))
            ->select(['id', 'nick_name', 'mobile', 'avatar'])
            ->get()
            ->keyBy('id')
            ->toArray();

        return $this->successData([
            'data' => [
                'data' => $comments->items(),
                'total' => $comments->total(),
            ],
            'users' => $users,
        ]);
    }

    public function check(Request $request)
    {
        $ids = $request->input('ids');
        $status = (int)$request->input('is_check');

        if (!$ids || !is_array($ids) || !in_array($status, [0, 1])) {
            return $this->error(__('参数错误'));
        }

        AdministratorLog::storeLog(
            AdministratorLog::MODULE_VOD_COMMENT,
            AdministratorLog::OPT_UPDATE,
            compact('ids', 'status')
        );

        if (0 === $status) {
            CourseComment::query()->whereIn('id', $ids)->delete();
        } else {
            CourseComment::query()->whereIn('id', $ids)->update(['is_check' => 1]);
        }

        return $this->success();
    }

    public function destroy(Request $request)
    {
        $ids = $request->input('ids');

        CourseComment::destroy($ids);

        AdministratorLog::storeLog(
            AdministratorLog::MODULE_VOD_COMMENT,
            AdministratorLog::OPT_DESTROY,
            compact('ids')
        );

        return $this->success();
    }
}
