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

use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Services\Member\Models\User;
use App\Services\Course\Models\Video;
use App\Services\Course\Models\Course;
use App\Services\Member\Models\UserVideo;
use App\Http\Requests\Backend\CourseVideoRequest;
use App\Services\Member\Models\UserVideoWatchRecord;

class CourseVideoController extends BaseController
{
    public function index(Request $request)
    {
        $keywords = $request->input('keywords', '');
        $courseId = $request->input('course_id');
        $sort = $request->input('sort', 'created_at');
        $order = $request->input('order', 'desc');

        $videos = Video::query()
            ->with(['course', 'chapter'])
            ->when($keywords, function ($query) use ($keywords) {
                return $query->where('title', 'like', "{$keywords}%");
            })
            ->when($courseId, function ($query) use ($courseId) {
                $query->where('course_id', $courseId);
            })
            ->orderBy($sort, $order)
            ->paginate($request->input('size', 20));

        $courses = Course::query()->select(['id', 'title'])->get();

        return $this->successData(compact('videos', 'courses'));
    }

    public function create()
    {
        $courses = Course::select(['id', 'title'])->orderByDesc('published_at')->get();

        return $this->successData(compact('courses'));
    }

    public function store(CourseVideoRequest $request, Video $video)
    {
        $video->fill($request->filldata())->save();

        $this->hook($video->course_id);

        return $this->success();
    }

    public function edit($id)
    {
        $video = Video::findOrFail($id);

        $courses = Course::all();

        return $this->successData(compact('video', 'courses'));
    }

    public function update(CourseVideoRequest $request, $id)
    {
        $video = Video::findOrFail($id);
        $video->fill($request->filldata())->save();

        $this->hook($video->course_id);

        return $this->success();
    }

    public function destroy($id)
    {
        $video = Video::findOrFail($id);
        $courseId = $video->course_id;
        $video->delete();

        $this->hook($courseId);

        return $this->success();
    }

    protected function hook($courseId)
    {
        $count = Video::query()->where('course_id', $courseId)->where('charge', '>', 0)->count();
        $isFree = $count === 0;
        Course::query()->where('id', $courseId)->update(['is_free' => $isFree]);
    }

    public function multiDestroy(Request $request)
    {
        $ids = $request->input('ids');
        $videos = Video::query()->whereIn('id', $ids)->get();
        foreach ($videos as $video) {
            $courseId = $video['course_id'];
            $video->delete();
            $this->hook($courseId);
        }

        return $this->success();
    }

    public function subscribes(Request $request, $videoId)
    {
        $userId = $request->input('user_id');
        $subscribeStartAt = $request->input('subscribe_start_at');
        $subscribeEndAt = $request->input('subscribe_end_at');

        $data = UserVideo::query()
            ->where('video_id', $videoId)
            ->when($userId, function ($query) use ($userId) {
                $query->where('user_id', $userId);
            })
            ->when($subscribeStartAt && $subscribeEndAt, function ($query) use ($subscribeStartAt, $subscribeEndAt) {
                $query->whereBetween('created_at', [$subscribeStartAt, $subscribeEndAt]);
            })
            ->orderByDesc('created_at')
            ->paginate($request->input('size', 10));

        $users = User::query()
            ->select(['id', 'nick_name', 'mobile', 'avatar'])
            ->whereIn('id', array_column($data->items(), 'user_id'))
            ->get()
            ->keyBy('id');

        return $this->successData([
            'data' => $data,
            'users' => $users,
        ]);
    }

    public function subscribeCreate(Request $request, $videoId)
    {
        $userId = $request->input('user_id');
        if (UserVideo::query()->where('user_id', $userId)->where('video_id', $videoId)->exists()) {
            return $this->error('订阅关系已存在');
        }

        if (!User::query()->where('id', $userId)->exists()) {
            return $this->error('用户不存在');
        }

        UserVideo::create([
            'user_id' => $userId,
            'video_id' => $videoId,
            'charge' => 0,
            'created_at' => Carbon::now(),
        ]);

        return $this->success();
    }

    public function subscribeDelete(Request $request, $videoId)
    {
        $userId = $request->input('user_id');
        UserVideo::query()->where('user_id', $userId)->where('video_id', $videoId)->delete();
        return $this->success();
    }

    public function watchRecords(Request $request, $videoId)
    {
        $userId = $request->input('user_id');
        $courseId = $request->input('course_id');
        $watchedStartAt = $request->input('watched_start_at');
        $watchedEndAt = $request->input('watched_end_at');

        $data = UserVideoWatchRecord::query()
            ->when($videoId, function ($query) use ($videoId) {
                $query->where('video_id', $videoId);
            })
            ->when($userId, function ($query) use ($userId) {
                $query->where('user_id', $userId);
            })
            ->when($courseId, function ($query) use ($courseId) {
                $query->where('course_id', $courseId);
            })
            ->when($watchedStartAt && $watchedEndAt, function ($query) use ($watchedStartAt, $watchedEndAt) {
                $query->whereBetween('watched_at', [$watchedStartAt, $watchedEndAt]);
            })
            ->orderByDesc('id')
            ->paginate($request->input('size', 10));

        // 视频
        $videos = Video::query()->select(['id', 'title', 'charge', 'duration'])
            ->whereIn('id', array_column($data->items(), 'video_id'))
            ->get()
            ->keyBy('id');

        // 用户
        $users = User::query()
            ->select(['id', 'nick_name', 'avatar', 'mobile'])
            ->whereIn('id', array_column($data->items(), 'user_id'))
            ->get()
            ->keyBy('id');

        return $this->successData([
            'data' => $data,
            'users' => $users,
            'videos' => $videos,
        ]);
    }
}
