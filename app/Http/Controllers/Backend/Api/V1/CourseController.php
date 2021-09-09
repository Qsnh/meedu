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
use App\Events\VodCourseCreatedEvent;
use App\Events\VodCourseUpdatedEvent;
use App\Services\Course\Models\Video;
use App\Services\Course\Models\Course;
use App\Events\VodCourseDestroyedEvent;
use App\Services\Member\Models\UserCourse;
use App\Http\Requests\Backend\CourseRequest;
use App\Services\Course\Models\CourseChapter;
use App\Services\Course\Models\CourseCategory;
use App\Services\Course\Models\CourseUserRecord;
use App\Services\Member\Models\UserVideoWatchRecord;

class CourseController extends BaseController
{
    public function index(Request $request)
    {
        $id = $request->input('id');
        $keywords = $request->input('keywords', '');
        $cid = $request->input('cid');

        // 排序
        $sort = $request->input('sort', 'created_at');
        $order = $request->input('order', 'desc');

        $courses = Course::query()
            ->select([
                'id', 'user_id', 'title', 'slug', 'thumb', 'charge', 'short_description',
                'published_at', 'is_show', 'category_id', 'is_rec', 'user_count', 'is_free',
                'comment_status', 'created_at', 'updated_at',
            ])
            ->with(['category:id,name'])
            ->withCount(['videos', 'chapters', 'comments'])
            ->when($id, function ($query) use ($id) {
                $query->where('id', $id);
            })
            ->when($keywords, function ($query) use ($keywords) {
                return $query->where('title', 'like', '%' . $keywords . '%');
            })
            ->when($cid, function ($query) use ($cid) {
                return $query->whereCategoryId($cid);
            })
            ->orderBy($sort, $order)
            ->paginate($request->input('size', 10));

        $categories = CourseCategory::query()->select(['id', 'name'])->orderBy('sort')->get();

        return $this->successData(compact('courses', 'categories'));
    }

    public function create()
    {
        $categories = CourseCategory::query()->select(['id', 'name', 'sort'])->orderBy('sort')->get();
        return $this->successData(compact('categories'));
    }

    public function store(CourseRequest $request, Course $course)
    {
        $course->fill($request->filldata())->save();

        event(new VodCourseCreatedEvent(
            $course['id'],
            $course['title'],
            $course['charge'],
            $course['thumb'],
            $course['short_description'],
            $course['original_desc']
        ));

        return $this->success();
    }

    public function edit($id)
    {
        $course = Course::query()->where('id', $id)->firstOrFail();

        return $this->successData($course);
    }

    public function update(CourseRequest $request, $id)
    {
        $data = $request->filldata();

        $course = Course::query()->where('id', $id)->firstOrFail();

        $course->fill($data)->save();

        event(new VodCourseUpdatedEvent(
            $course['id'],
            $course['title'],
            $course['charge'],
            $course['thumb'],
            $course['short_description'],
            $course['original_desc']
        ));

        return $this->success();
    }

    public function destroy($id)
    {
        $course = Course::query()->where('id', $id)->firstOrFail();

        if ($course->videos()->exists()) {
            return $this->error(__('当前课程下存在视频无法删除'));
        }

        $course->delete();

        event(new VodCourseDestroyedEvent($id));

        return $this->success();
    }

    // 课程观看记录
    public function watchRecords(Request $request, $courseId)
    {
        $userId = (int)$request->input('user_id');
        $isWatched = (int)$request->input('is_watched');

        // 看完时间范围筛选
        $watchStartAt = $request->input('watched_start_at');
        $watchEndAt = $request->input('watched_end_at');

        // 排序字段
        $sort = $request->input('sort', 'id');
        $order = $request->input('order', 'desc');

        $data = CourseUserRecord::query()
            ->where('course_id', $courseId)
            ->when($userId, function ($query) use ($userId) {
                $query->where('user_id', $userId);
            })
            ->when($watchStartAt && $watchEndAt, function ($query) use ($watchStartAt, $watchEndAt) {
                $query->whereBetween('watched_at', [Carbon::parse($watchStartAt), Carbon::parse($watchEndAt)]);
            })
            ->when($isWatched !== -1, function ($query) use ($isWatched) {
                $query->where('is_watched', (int)$isWatched === 1 ? 1 : 0);
            })
            ->orderBy($sort, $order)
            ->paginate($request->input('size', 10));

        // 用户
        $users = User::query()
            ->select(['id', 'nick_name', 'avatar', 'mobile'])
            ->whereIn('id', array_column($data->items(), 'user_id'))
            ->get()
            ->keyBy('id');

        // 订阅记录
        $subscribeRecords = UserCourse::query()
            ->whereIn('user_id', array_column($data->items(), 'user_id'))
            ->where('course_id', $courseId)
            ->get()
            ->keyBy('user_id');

        return $this->successData([
            'data' => $data,
            'users' => $users,
            'subscribe_records' => $subscribeRecords,
        ]);
    }

    public function delWatchRecord(Request $request, $courseId)
    {
        $ids = $request->input('record_ids', []) ?: [0];

        CourseUserRecord::query()
            ->whereIn('id', $ids)
            ->where('course_id', $courseId)
            ->delete();

        return $this->success();
    }

    // 订阅记录
    public function subscribes(Request $request, $courseId)
    {
        $userId = $request->input('user_id');
        $subscribeStartAt = $request->input('subscribe_start_at');
        $subscribeEndAt = $request->input('subscribe_end_at');

        $data = UserCourse::query()
            ->when($userId, function ($query) use ($userId) {
                $query->where('user_id', $userId);
            })
            ->when($subscribeStartAt && $subscribeEndAt, function ($query) use ($subscribeStartAt, $subscribeEndAt) {
                $query->whereBetween('created_at', [Carbon::parse($subscribeStartAt), Carbon::parse($subscribeEndAt)]);
            })
            ->where('course_id', $courseId)
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

    public function createSubscribe(Request $request, $courseId)
    {
        $userId = $request->input('user_id');
        if (!$userId) {
            return $this->error(__('参数错误'));
        }

        if (!is_array($userId)) {
            $userId = [$userId];
        }

        $existsIds = UserCourse::query()
            ->whereIn('user_id', $userId)
            ->where('course_id', $courseId)
            ->select(['user_id'])
            ->get()
            ->pluck('user_id')
            ->toArray();

        $userId = array_diff($userId, $existsIds);

        foreach ($userId as $id) {
            UserCourse::create([
                'course_id' => $courseId,
                'user_id' => $id,
                'charge' => 0,
                'created_at' => Carbon::now(),
            ]);
        }

        // 课程订阅数量更新
        Course::query()
            ->where('id', $courseId)
            ->update([
                'user_count' => UserCourse::query()->where('course_id', $courseId)->count(),
            ]);

        return $this->success();
    }

    public function deleteSubscribe(Request $request, $courseId)
    {
        $userId = $request->input('user_id');

        UserCourse::query()->where('course_id', $courseId)->where('user_id', $userId)->delete();

        // 课程订阅数量更新
        Course::query()
            ->where('id', $courseId)
            ->decrement('user_count');

        return $this->success();
    }

    public function all()
    {
        $courses = Course::query()->select(['id', 'title'])->get();
        return $this->successData(['data' => $courses]);
    }

    public function videoWatchRecords($courseId, $userId)
    {
        $course = Course::query()->where('id', $courseId)->firstOrFail();
        $chapters = CourseChapter::query()
            ->where('course_id', $course['id'])
            ->orderBy('sort')
            ->get();
        $videos = Video::query()
            ->select(['id', 'title', 'duration', 'course_id', 'chapter_id'])
            ->where('course_id', $course['id'])
            ->orderBy('published_at')
            ->get();

        // 视频观看记录
        $videoWatchRecords = UserVideoWatchRecord::query()
            ->where('user_id', $userId)
            ->whereIn('video_id', $videos->pluck('id')->toArray())
            ->get()
            ->keyBy('video_id');

        $data = [];

        if ($chapters->isEmpty()) {
            foreach ($videos as $videoItem) {
                $tmp = [
                    'video_title' => $videoItem['title'],
                    'duration' => $videoItem['duration'],
                    'watch_seconds' => $videoWatchRecords[$videoItem['id']]['watch_seconds'] ?? 0,
                    'watched_at' => $videoWatchRecords[$videoItem['id']]['watched_at'] ?? '',
                ];
                $data[] = $tmp;
            }
        } else {
            $videos = $videos->groupBy('chapter_id')->toArray();
            foreach ($chapters as $chapter) {
                $list = $videos[$chapter['id']];
                if (!$list) {
                    continue;
                }

                foreach ($list as $videoItem) {
                    $tmp = [
                        'video_title' => sprintf('%s-%s', $chapter['title'], $videoItem['title']),
                        'duration' => $videoItem['duration'],
                        'watch_seconds' => $videoWatchRecords[$videoItem['id']]['watch_seconds'] ?? 0,
                        'watched_at' => $videoWatchRecords[$videoItem['id']]['watched_at'] ?? '',
                    ];
                    $data[] = $tmp;
                }
            }
        }

        return $this->successData([
            'data' => $data,
        ]);
    }
}
