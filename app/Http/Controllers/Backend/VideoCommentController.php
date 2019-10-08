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

use App\Models\VideoComment;
use App\Http\Controllers\Controller;

class VideoCommentController extends Controller
{
    public function index()
    {
        $comments = VideoComment::orderByDesc('created_at')->paginate(20);

        return view('backend.video.comment.index', compact('comments'));
    }

    public function destroy($id)
    {
        VideoComment::destroy($id);
        flash('删除成功', 'success');

        return back();
    }
}
