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
        $courseId = $request->input('course_id');
        $videoId = $request->input('video_id');
        $userId = $request->input('user_id');
        $createdAt = $request->input('created_at');

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
            ->when($createdAt && is_array($createdAt), function ($query) use ($createdAt) {
                $query->whereBetween('created_at', [Carbon::parse($createdAt[0]), Carbon::parse($createdAt[1])]);
            })
            ->orderByDesc('id')
            ->paginate($request->input('size', 10));

        $users = User::query()
            ->whereIn('id', array_column($comments->items(), 'user_id'))
            ->select(['id', 'nick_name', 'avatar', 'mobile'])
            ->get()
            ->keyBy('id');

        AdministratorLog::storeLog(
            AdministratorLog::MODULE_VOD_VIDEO_COMMENT,
            AdministratorLog::OPT_VIEW,
            compact('courseId', 'videoId', 'userId', 'createdAt')
        );

        return $this->successData([
            'data' => $comments,
            'users' => $users,
        ]);
    }

    public function destroy(Request $request)
    {
        $ids = $request->input('ids');

        VideoComment::destroy($ids);

        AdministratorLog::storeLog(
            AdministratorLog::MODULE_VOD_VIDEO_COMMENT,
            AdministratorLog::OPT_DESTROY,
            compact('ids')
        );

        return $this->success();
    }
}
