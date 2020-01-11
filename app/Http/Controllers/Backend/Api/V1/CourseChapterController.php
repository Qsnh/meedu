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

use App\Constant\BackendApiConstant;
use App\Services\Course\Models\Course;
use App\Services\Course\Models\CourseChapter;
use App\Http\Requests\Backend\CourseChapterRequest;

class CourseChapterController extends BaseController
{
    public function index($courseId)
    {
        $course = Course::findOrFail($courseId);

        $chapters = $course->chapters()->orderBy('sort')->get();

        return $this->successData(compact('course', 'chapters'));
    }

    public function store(CourseChapterRequest $request, $courseId)
    {
        $course = Course::findOrFail($courseId);
        $course->chapters()->save(new CourseChapter($request->filldata()));

        return $this->success();
    }

    public function edit($courseId, $id)
    {
        $chapter = CourseChapter::findOrFail($id);

        return $this->successData($chapter);
    }

    public function update(CourseChapterRequest $request, $courseId, $id)
    {
        $one = CourseChapter::findOrFail($id);
        $one->fill($request->filldata())->save();

        return $this->success();
    }

    public function destroy($courseId, $id)
    {
        $courseChapter = CourseChapter::findOrFail($id);
        if ($courseChapter->videos()->count()) {
            return $this->error(BackendApiConstant::COURSE_CHAPTER_BAN_DELETE_FOR_VIDEOS);
        }
        $courseChapter->delete();

        return $this->success();
    }
}
