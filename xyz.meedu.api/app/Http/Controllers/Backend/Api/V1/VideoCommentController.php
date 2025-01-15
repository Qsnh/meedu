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
use App\Services\Course\Models\Video;
use App\Services\Course\Models\VideoComment;

class VideoCommentController extends BaseController
{
    public function index(Request $request)
    {
        $courseId = (int)$request->input('course_id');
        $videoId = (int)$request->input('video_id');
        $userId = (int)$request->input('user_id');
        $createdAt = $request->input('created_at');
        $isCheck = (int)$request->input('is_check');

        if ($createdAt && !is_array($createdAt)) {
            return $this->error(__('参数错误'));
        }

        AdministratorLog::storeLog(
            AdministratorLog::MODULE_VOD_VIDEO_COMMENT,
            AdministratorLog::OPT_VIEW,
            compact('courseId', 'videoId', 'userId', 'createdAt')
        );

        $comments = VideoComment::query()
            ->with(['video:id,course_id,title,charge,duration', 'video.course:id,title,thumb,charge'])
            ->when($courseId, function ($query) use ($courseId) {
                $videoIds = Video::query()->select(['id'])->where('course_id', $courseId)->get()->pluck('id');
                $query->whereIn('video_id', $videoIds);
            })
            ->when($videoId, function ($query) use ($videoId) {
                $query->where('video_id', $videoId);
            })
            ->when($userId, function ($query) use ($userId) {
                $query->where('user_id', $userId);
            })
            ->when(in_array($isCheck, [0, 1]), function ($query) use ($isCheck) {
                $query->where('is_check', $isCheck);
            })
            ->when($createdAt, function ($query) use ($createdAt) {
                $query->whereBetween('created_at', [
                    Carbon::parse($createdAt[0])->toDateTimeLocalString(),
                    Carbon::parse($createdAt[1])->toDateTimeLocalString(),
                ]);
            })
            ->orderByDesc('id')
            ->paginate($request->input('size', 10));

        $users = User::query()
            ->whereIn('id', array_column($comments->items(), 'user_id'))
            ->select(['id', 'nick_name', 'avatar', 'mobile'])
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
        $status = $request->input('is_check');

        if (!$ids || !is_array($ids) || !in_array($status, [0, 1])) {
            return $this->error(__('参数错误'));
        }

        AdministratorLog::storeLog(
            AdministratorLog::MODULE_VOD_VIDEO_COMMENT,
            AdministratorLog::OPT_UPDATE,
            compact('ids', 'status')
        );

        if (0 === $status) {
            VideoComment::query()->whereIn('id', $ids)->delete();
        } else {
            VideoComment::query()->whereIn('id', $ids)->update(['is_check' => 1]);
        }

        return $this->success();
    }

    public function destroy(Request $request)
    {
        $ids = $request->input('ids');

        if (!$ids || !is_array($ids)) {
            return $this->error(__('参数错误'));
        }

        AdministratorLog::storeLog(
            AdministratorLog::MODULE_VOD_VIDEO_COMMENT,
            AdministratorLog::OPT_DESTROY,
            compact('ids')
        );

        VideoComment::destroy($ids);

        return $this->success();
    }
}
