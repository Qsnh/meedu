<?php

/*
 * This file is part of the MeEdu.
 *
 * (c) 杭州白书科技有限公司
 */

namespace App\Http\Controllers\Backend\Api\V1;

use Illuminate\Http\Request;
use App\Models\AdministratorLog;
use App\Services\Course\Models\Course;
use Illuminate\Support\Facades\Storage;
use App\Services\Course\Models\CourseAttach;
use App\Http\Requests\Backend\CourseAttachRequest;

class CourseAttachController extends BaseController
{
    public function index(Request $request)
    {
        $courseId = $request->input('course_id');
        $course = Course::query()->where('id', $courseId)->firstOrFail();
        $attach = CourseAttach::query()->where('course_id', $courseId)->get();

        AdministratorLog::storeLog(
            AdministratorLog::MODULE_VOD_ATTACH,
            AdministratorLog::OPT_VIEW,
            compact('courseId')
        );

        return $this->successData([
            'data' => $attach,
            'course' => $course,
        ]);
    }

    public function store(CourseAttachRequest $request)
    {
        $data = $request->filldata();
        CourseAttach::create($data);

        AdministratorLog::storeLog(
            AdministratorLog::MODULE_VOD_ATTACH,
            AdministratorLog::OPT_STORE,
            $data
        );

        return $this->success();
    }

    public function destroy($id)
    {
        $attach = CourseAttach::query()->where('id', $id)->firstOrFail();

        $path = $attach['path'];

        // 删除附件
        Storage::disk(config('meedu.upload.attach.course.disk'))->delete($path);

        // 删除数据库记录
        $attach->delete();

        AdministratorLog::storeLog(
            AdministratorLog::MODULE_VOD_ATTACH,
            AdministratorLog::OPT_DESTROY,
            compact('path', 'id')
        );

        return $this->success();
    }
}
