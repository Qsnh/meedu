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
use App\Constant\BackendApiConstant;
use App\Services\Member\Models\User;
use App\Services\Course\Models\Video;
use App\Services\Course\Models\Course;
use App\Services\Member\Models\UserCourse;
use App\Http\Requests\Backend\CourseRequest;
use App\Services\Course\Models\CourseCategory;
use App\Services\Course\Models\CourseUserRecord;

class CourseController extends BaseController
{
    public function index(Request $request)
    {
        $id = $request->input('id');
        $keywords = $request->input('keywords', '');
        $cid = $request->input('cid');
        $userId = $request->input('user_id');

        // 排序
        $sort = $request->input('sort', 'created_at');
        $order = $request->input('order', 'desc');

        $courses = Course::query()
            ->when($id, function ($query) use ($id) {
                $query->where('id', $id);
            })
            ->when($keywords, function ($query) use ($keywords) {
                return $query->where('title', 'like', '%' . $keywords . '%');
            })
            ->when($cid, function ($query) use ($cid) {
                return $query->whereCategoryId($cid);
            })
            ->when($userId, function ($query) use ($userId) {
                $courseIds = UserCourse::query()->where('user_id', $userId)->select(['course_id'])->get()->pluck('course_id')->toArray();
                $courseIds || $courseIds = [0];
                $query->whereIn('id', $courseIds);
            })
            ->orderBy($sort, $order)
            ->paginate($request->input('size', 12));

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

        return $this->success();
    }

    public function edit($id)
    {
        $course = Course::findOrFail($id);

        return $this->successData($course);
    }

    public function update(CourseRequest $request, $id)
    {
        $data = $request->filldata();
        /**
         * @var Course
         */
        $course = Course::findOrFail($id);
        $originIsShow = $course->is_show;
        $course->fill($data)->save();

        if ($originIsShow !== $data['is_show']) {
            // 修改下面的视频显示状态
            Video::where('course_id', $course->id)->update(['is_show' => $data['is_show']]);
        }

        return $this->success();
    }

    public function destroy($id)
    {
        $course = Course::findOrFail($id);
        if ($course->videos()->exists()) {
            return $this->error(BackendApiConstant::COURSE_BAN_DELETE_FOR_VIDEOS);
        }

        $course->delete();

        return $this->success();
    }

    // 课程观看记录
    public function watchRecords(Request $request, $courseId)
    {
        $userId = (int)$request->input('user_id');
        $watchStartAt = $request->input('watched_start_at');
        $watchEndAt = $request->input('watched_end_at');

        $data = CourseUserRecord::query()
            ->where('course_id', $courseId)
            ->when($userId, function ($query) use ($userId) {
                $query->where('user_id', $userId);
            })
            ->when($watchStartAt && $watchEndAt, function ($query) use ($watchStartAt, $watchEndAt) {
                $query->whereBetween('watched_at', [$watchStartAt, $watchEndAt]);
            })
            ->orderByDesc('id')
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
                $query->whereBetween('created_at', [$subscribeStartAt, $subscribeEndAt]);
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
        $exists = UserCourse::query()->where('course_id', $courseId)->where('user_id', $userId)->exists();
        if ($exists) {
            return $this->error('订阅关系已存在');
        }
        if (!User::query()->where('id', $userId)->exists()) {
            return $this->error('用户不存在');
        }

        UserCourse::create([
            'course_id' => $courseId,
            'user_id' => $userId,
            'charge' => 0,
            'created_at' => Carbon::now(),
        ]);

        return $this->success();
    }

    public function deleteSubscribe(Request $request, $courseId)
    {
        $userId = $request->input('user_id');
        UserCourse::query()->where('course_id', $courseId)->where('user_id', $userId)->delete();
        return $this->success();
    }

    public function all()
    {
        $courses = Course::query()->select(['id', 'title'])->get();
        return $this->successData(['data' => $courses]);
    }
}
