<?php

/*
 * This file is part of the Qsnh/meedu.
 *
 * (c) 杭州白书科技有限公司
 */

namespace App\Http\Controllers\Backend\Api\V1;

use Illuminate\Support\Arr;
use App\Models\AdministratorLog;
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

        AdministratorLog::storeLog(
            AdministratorLog::MODULE_VOD_CHAPTER,
            AdministratorLog::OPT_VIEW,
            compact('courseId')
        );

        return $this->successData(compact('course', 'chapters'));
    }

    public function store(CourseChapterRequest $request, $courseId)
    {
        $data = $request->filldata();
        $data['course_id'] = $courseId;

        CourseChapter::create($data);

        AdministratorLog::storeLog(
            AdministratorLog::MODULE_VOD_CHAPTER,
            AdministratorLog::OPT_STORE,
            $data
        );

        return $this->success();
    }

    public function edit($courseId, $id)
    {
        $chapter = CourseChapter::query()
            ->where('id', $id)
            ->where('course_id', $courseId)
            ->firstOrFail();

        AdministratorLog::storeLog(
            AdministratorLog::MODULE_VOD_CHAPTER,
            AdministratorLog::OPT_VIEW,
            compact('id', 'courseId')
        );

        return $this->successData($chapter);
    }

    public function update(CourseChapterRequest $request, $courseId, $id)
    {
        $data = $request->filldata();

        $chapter = CourseChapter::query()->where('id', $id)->where('course_id', $courseId)->firstOrFail();

        AdministratorLog::storeLogDiff(
            AdministratorLog::MODULE_VOD_CHAPTER,
            AdministratorLog::OPT_UPDATE,
            Arr::only($data, ['course_id', 'title', 'sort']),
            Arr::only($chapter->toArray(), ['course_id', 'title', 'sort']),
        );

        $chapter->fill($data)->save();

        return $this->success();
    }

    public function destroy($courseId, $id)
    {
        $chapter = CourseChapter::query()->where('id', $id)->where('course_id', $courseId)->firstOrFail();

        if ($chapter->videos()->count()) {
            return $this->error(__('当前章节下存在视频无法删除'));
        }

        $chapter->delete();

        AdministratorLog::storeLog(
            AdministratorLog::MODULE_VOD_CHAPTER,
            AdministratorLog::OPT_DESTROY,
            compact('id', 'courseId')
        );

        return $this->success();
    }
}
