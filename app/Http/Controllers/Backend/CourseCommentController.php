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

use App\Models\CourseComment;
use App\Http\Controllers\Controller;

class CourseCommentController extends Controller
{
    public function index()
    {
        $comments = CourseComment::orderByDesc('created_at')->paginate(20);

        return view('backend.course.comment.index', compact('comments'));
    }

    public function destroy($id)
    {
        CourseComment::destroy($id);
        flash('删除成功', 'success');

        return back();
    }
}
