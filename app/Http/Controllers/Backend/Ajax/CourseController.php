<?php

/*
 * This file is part of the Qsnh/meedu.
 *
 * (c) XiaoTeng <616896861@qq.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace App\Http\Controllers\Backend\Ajax;

use App\Models\Course;
use App\Http\Controllers\Controller;

class CourseController extends Controller
{
    public function chapters($courseId)
    {
        $course = Course::findOrFail($courseId);
        $chapters = $course->chapters()->orderBy('sort')->get();

        return $chapters;
    }
}
