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

use App\Models\VideoComment;

class VideoCommentController extends BaseController
{
    public function index()
    {
        $comments = VideoComment::with(['user', 'video.course'])
            ->orderByDesc('id')
            ->paginate(request()->input('size', 12));

        return $this->successData($comments);
    }

    public function destroy($id)
    {
        VideoComment::destroy($id);

        return $this->success();
    }
}
