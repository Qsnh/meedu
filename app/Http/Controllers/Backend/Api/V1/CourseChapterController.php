<?php

/*
 * This file is part of the Qsnh/meedu.
 *
 * (c) 杭州白书科技有限公司
 */

namespace App\Http\Controllers\Backend\Api\V1;

use App\Services\Course\Models\Course;
use App\Services\Course\Models\CourseChapter;
use App\Http\Requests\Backend\CourseChapterRequest;

class CourseChapterController extends BaseController
{
    public function index($courseId)
    {
        $course = Course::query()->where('id', $courseId)->firstOrFail();

        $chapters = CourseChapter::query()
            ->where('course_id', $course['id'])
            ->orderBy('sort')
            ->get();

        return $this->successData(compact('course', 'chapters'));
    }

    public function store(CourseChapterRequest $request, $courseId)
    {
        $course = Course::query()->where('id', $courseId)->firstOrFail();

        $course->chapters()->save(new CourseChapter($request->filldata()));

        return $this->success();
    }

    public function edit($courseId, $id)
    {
        $chapter = CourseChapter::query()->where('id', $id)->where('course_id', $courseId)->firstOrFail();

        return $this->successData($chapter);
    }

    public function update(CourseChapterRequest $request, $courseId, $id)
    {
        $chapter = CourseChapter::query()->where('id', $id)->where('course_id', $courseId)->firstOrFail();

        $chapter->fill($request->filldata())->save();

        return $this->success();
    }

    public function destroy($courseId, $id)
    {
        $chapter = CourseChapter::query()->where('id', $id)->where('course_id', $courseId)->firstOrFail();

        if ($chapter->videos()->count()) {
            return $this->error(__('当前章节下存在视频无法删除'));
        }

        $chapter->delete();

        return $this->success();
    }
}
