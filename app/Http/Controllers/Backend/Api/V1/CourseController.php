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
use App\Constant\BackendApiConstant;
use App\Services\Member\Models\User;
use App\Services\Course\Models\Video;
use App\Services\Course\Models\Course;
use App\Http\Requests\Backend\CourseRequest;
use App\Services\Course\Models\CourseCategory;
use App\Services\Course\Models\CourseUserRecord;

class CourseController extends BaseController
{
    public function index(Request $request)
    {
        $keywords = $request->input('keywords', '');
        $cid = $request->input('cid');
        $sort = $request->input('sort', 'created_at');
        $order = $request->input('order', 'desc');
        $courses = Course::when($keywords, function ($query) use ($keywords) {
            return $query->where('title', 'like', '%' . $keywords . '%');
        })->when($cid, function ($query) use ($cid) {
            return $query->whereCategoryId($cid);
        })
            ->orderBy($sort, $order)
            ->paginate(12);

        $courses->appends($request->input());

        $categories = CourseCategory::select(['id', 'name'])->orderBy('sort')->get();

        return $this->successData(compact('courses', 'categories'));
    }

    public function create()
    {
        $categories = CourseCategory::show()->get();
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

        // 判断是否修改了显示的状态
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

    public function subscribeUsers(Request $request, $courseId)
    {
        $data = CourseUserRecord::whereCourseId($courseId)->paginate($request->input('size', 12));
        $users = User::select(['id', 'nick_name', 'avatar', 'mobile'])->whereIn('id', array_column($data->all(), 'user_id'))->get()->keyBy('id');
        return $this->successData(compact('data', 'users'));
    }
}
