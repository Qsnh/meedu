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

use App\Models\Course;
use App\Models\CourseChapter;
use App\Http\Controllers\Controller;
use App\Http\Requests\Backend\CourseChapterRequest;

class CourseChapterController extends Controller
{
    public function index($courseId)
    {
        $course = Course::findOrFail($courseId);

        $rows = $course->chapters()->orderBy('sort')->get();

        return view('backend.coursechapter.index', compact('rows', 'course'));
    }

    public function create($courseId)
    {
        $course = Course::findOrFail($courseId);

        return view('backend.coursechapter.create', compact('course'));
    }

    public function store(CourseChapterRequest $request, $courseId)
    {
        $course = Course::findOrFail($courseId);
        $course->chapters()->save(new CourseChapter($request->filldata()));
        flash('添加成功', 'success');

        return back();
    }

    public function edit($id)
    {
        $one = CourseChapter::findOrFail($id);

        return view('backend.coursechapter.edit', compact('one'));
    }

    public function update(CourseChapterRequest $request, $id)
    {
        $one = CourseChapter::findOrFail($id);
        $one->fill($request->filldata())->save();
        flash('编辑成功', 'success');

        return back();
    }

    public function destroy($id)
    {
        $courseChapter = CourseChapter::findOrFail($id);
        if ($courseChapter->videos()->count()) {
            flash('无法删除，该章节下面存在视频', 'warning');
        } else {
            $courseChapter->delete();
            flash('删除成功', 'success');
        }

        return back();
    }
}
