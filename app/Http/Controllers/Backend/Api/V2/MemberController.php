<?php

/*
 * This file is part of the MeEdu.
 *
 * (c) 杭州白书科技有限公司
 */

namespace App\Http\Controllers\Backend\Api\V2;

use Illuminate\Support\Arr;
use Illuminate\Http\Request;
use App\Models\AdministratorLog;
use App\Services\Course\Models\Video;
use App\Services\Member\Models\UserVideo;
use App\Meedu\ServiceV2\Models\CourseUserRecord;
use App\Meedu\ServiceV2\Models\UserVideoWatchRecord;
use App\Meedu\ServiceV2\Services\UserServiceInterface;
use App\Meedu\ServiceV2\Services\CourseServiceInterface;

class MemberController extends BaseController
{
    public function courses(Request $request, UserServiceInterface $userService, CourseServiceInterface $courseService)
    {
        $page = (int)$request->input('page', 1);
        $pageSize = (int)$request->input('size', 10);

        $userId = (int)$request->input('user_id');

        ['data' => $data, 'total' => $total] = $userService->getUserLearnedCoursePaginateWithProgress($userId, $page, $pageSize);

        if ($data) {
            $courseIds = array_column($data, 'course_id');

            // 关联的课程信息
            $courses = $courseService->chunk($courseIds, ['id', 'title', 'thumb', 'charge'], [], [], ['videos']);
            $courses = array_column($courses, null, 'id');

            // 关联课程视频信息
            $videoIds = [];
            foreach ($data as $tmpItem) {
                $videoIds[] = $tmpItem['last_view_video']['video_id'] ?? 0;
            }
            $videoIds = array_unique($videoIds);
            $videos = [];
            if ($videoIds) {
                $videos = $courseService->videoChunk($videoIds, ['id', 'title', 'duration', 'published_at'], [], [], []);
                $videos = array_column($videos, null, 'id');
            }

            foreach ($data as $key => $item) {
                $data[$key]['course'] = $courses[$item['course_id']] ?? [];
                if ($item['last_view_video']) {
                    $item['last_view_video'] = array_merge(
                        $item['last_view_video'],
                        ['video' => $videos[$item['last_view_video']['video_id']] ?? []],
                    );
                }
            }
        }

        AdministratorLog::storeLog(
            AdministratorLog::MODULE_MEMBER,
            AdministratorLog::OPT_VIEW,
            compact('page', 'pageSize', 'userId')
        );

        return $this->successData([
            'data' => $data,
            'total' => $total,
        ]);
    }

    public function videos(Request $request)
    {
        $page = (int)$request->input('page', 1);
        $pageSize = (int)$request->input('size', 10);

        $userId = (int)$request->input('user_id');

        $userVideos = UserVideo::query()
            ->where('user_id', $userId)
            ->orderByDesc('created_at')
            ->paginate($pageSize, ['*'], '', $page);

        $total = $userVideos->total();
        $data = $userVideos->items();

        if ($data) {
            $videoIds = array_column($data, 'video_id');

            // 关联的视频
            $videos = Video::query()
                ->select(['id', 'title', 'duration'])
                ->whereIn('id', $videoIds)
                ->get()
                ->keyBy('id')
                ->toArray();

            // 关联的学习记录
            $watchRecords = UserVideoWatchRecord::query()
                ->where('user_id', $userId)
                ->whereIn('video_id', $videoIds)
                ->get()
                ->keyBy('video_id')
                ->toArray();

            foreach ($data as $key => $item) {
                $data[$key]['video'] = $videos[$item['video_id']] ?? [];
                $data[$key]['watch_record'] = $watchRecords[$item['video_id']] ?? [];
            }
        }

        AdministratorLog::storeLog(
            AdministratorLog::MODULE_MEMBER,
            AdministratorLog::OPT_VIEW,
            compact('page', 'pageSize', 'userId')
        );

        return $this->successData([
            'data' => $data,
            'total' => $total,
        ]);
    }

    public function courseProgress(Request $request)
    {
        $userId = (int)$request->input('user_id');
        $courseId = (int)$request->input('course_id');

        $videos = Video::query()
            ->select(['id', 'title', 'duration'])
            ->where('course_id', $courseId)
            ->get()
            ->keyBy('id')
            ->toArray();
        $videoIds = array_column($videos, 'id');

        // 关联的学习记录
        $watchRecords = UserVideoWatchRecord::query()
            ->where('user_id', $userId)
            ->whereIn('video_id', $videoIds)
            ->get()
            ->keyBy('video_id')
            ->toArray();

        foreach ($videos as $key => $videoItem) {
            $videos[$key]['watch_record'] = $watchRecords[$videoItem['id']] ?? [];
        }

        // 课程的观看记录进度
        $courseWatchRecord = CourseUserRecord::query()->where('user_id', $userId)->where('course_id', $courseId)->first();
        if ($courseWatchRecord) {
            $courseWatchRecord = Arr::only($courseWatchRecord->toArray(), [
                'is_watched', 'watched_at', 'created_at', 'updated_at', 'progress',
            ]);
        } else {
            $courseWatchRecord = [
                'is_watched' => 0,
                'watched_at' => null,
                'progress' => 0,
                'created_at' => null,
                'updated_at' => null,
            ];
        }

        AdministratorLog::storeLog(
            AdministratorLog::MODULE_MEMBER,
            AdministratorLog::OPT_VIEW,
            compact('userId', 'courseId')
        );

        return $this->successData([
            'videos' => $videos,
            'course_watch_record' => $courseWatchRecord,
        ]);
    }

    public function destroy(UserServiceInterface $userService, $id)
    {
        $id = (int)$id;
        $userService->destroyUser($id);
        return $this->success();
    }
}
