<?php

/*
 * This file is part of the Qsnh/meedu.
 *
 * (c) XiaoTeng <616896861@qq.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace App\Http\Controllers\Frontend;

use App\Models\Video;
use App\Models\Course;
use App\Http\Controllers\Controller;
use App\Http\Requests\Frontend\CourseOrVideoCommentCreateRequest;

class AjaxController extends Controller
{
    /**
     * 课程评论.
     *
     * @param CourseOrVideoCommentCreateRequest $request
     * @param $courseId
     *
     * @return array
     */
    public function courseCommentHandler(CourseOrVideoCommentCreateRequest $request, $courseId)
    {
        $course = Course::findOrFail($courseId);
        $comment = $course->commentHandler($request->input('content'));
        if ($comment) {
            return [
                'content' => $comment->getContent(),
                'created_at' => $comment->created_at->diffForHumans(),
                'user' => [
                    'nick_name' => $comment->user->nick_name,
                    'avatar' => $comment->user->avatar,
                    'role' => $comment->user->role ? $comment->user->role->name : '免费会员',
                ],
            ];
        }

        return ['status' => 500, 'message' => '出现异常'];
    }

    /**
     * 视频评论.
     *
     * @param CourseOrVideoCommentCreateRequest $request
     * @param $videoId
     *
     * @return array
     */
    public function videoCommentHandler(CourseOrVideoCommentCreateRequest $request, $videoId)
    {
        $video = Video::findOrFail($videoId);
        $comment = $video->commentHandler($request->input('content'));
        if ($comment) {
            return [
                'content' => $comment->getContent(),
                'created_at' => $comment->created_at->diffForHumans(),
                'user' => [
                    'nick_name' => $comment->user->nick_name,
                    'avatar' => $comment->user->avatar,
                    'role' => $comment->user->role ? $comment->user->role->name : '免费会员',
                ],
            ];
        }

        return ['status' => 500, 'message' => '出现异常'];
    }
}
