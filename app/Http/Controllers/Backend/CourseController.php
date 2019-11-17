<?php

/*
 * This file is part of the Qsnh/meedu.
 *
 * (c) XiaoTeng <616896861@qq.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace App\Http\Controllers\Backend;

use App\Models\Video;
use App\Models\Course;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\Backend\CourseRequest;

class CourseController extends Controller
{
    public function index(Request $request)
    {
        $keywords = $request->input('keywords', '');
        $courses = Course::when($keywords, function ($query) use ($keywords) {
            return $query->where('title', 'like', '%'.$keywords.'%');
        })
            ->orderByDesc('created_at')
            ->paginate(10);

        $courses->appends($request->input());

        return view('backend.course.index', compact('courses'));
    }

    public function create()
    {
        return view('backend.course.create');
    }

    public function store(CourseRequest $request, Course $course)
    {
        $course->fill($request->filldata())->save();
        flash('课程添加成功', 'success');

        return back();
    }

    public function edit($id)
    {
        $course = Course::findOrFail($id);

        return view('backend.course.edit', compact('course'));
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
        flash('课程编辑成功', 'success');

        // 判断是否修改了显示的状态
        if ($originIsShow != $data['is_show']) {
            // 修改下面的视频
            Video::where('course_id', $course->id)->update(['is_show' => $data['is_show']]);
        }

        return back();
    }

    public function destroy($id)
    {
        $course = Course::findOrFail($id);
        if ($course->videos()->exists()) {
            flash('该课程下存在视频，无法删除');
        } else {
            $course->delete();
            flash('删除成功', 'success');
        }

        return back();
    }
}
