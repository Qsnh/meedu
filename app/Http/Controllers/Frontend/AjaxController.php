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

use Carbon\Carbon;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Services\Member\Services\UserService;
use App\Services\Course\Services\VideoService;
use App\Services\Course\Services\CourseService;
use App\Services\Course\Services\VideoCommentService;
use App\Services\Course\Services\CourseCommentService;
use App\Http\Requests\Frontend\CourseOrVideoCommentCreateRequest;

class AjaxController extends Controller
{
    protected $videoCommentService;
    protected $courseCommentService;
    protected $userService;
    protected $courseService;
    protected $videoService;

    public function __construct(
        VideoCommentService $videoCommentService,
        CourseCommentService $courseCommentService,
        UserService $userService,
        VideoService $videoService,
        CourseService $courseService
    ) {
        $this->videoCommentService = $videoCommentService;
        $this->courseCommentService = $courseCommentService;
        $this->userService = $userService;
        $this->videoService = $videoService;
        $this->courseService = $courseService;
    }

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
        $course = $this->courseService->find($courseId);
        ['content' => $content] = $request->filldata();
        $comment = $this->courseCommentService->create(Auth::id(), $course['id'], $content);
        $user = $this->userService->find(Auth::id(), ['role']);

        return [
            'content' => $comment['render_content'],
            'created_at' => Carbon::parse($comment['created_at'])->diffForHumans(),
            'user' => [
                'nick_name' => $user['nick_name'],
                'avatar' => $user['avatar'],
                'role' => $user['role'] ? $user['role']['name'] : '免费会员',
            ],
        ];
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
        $video = $this->videoService->find($videoId);
        ['content' => $content] = $request->filldata();
        $comment = $this->videoCommentService->create(Auth::id(), $video['id'], $content);
        $user = $this->userService->find(Auth::id(), ['role']);

        return [
            'content' => $comment['render_content'],
            'created_at' => Carbon::parse($comment['created_at'])->diffForHumans(),
            'user' => [
                'nick_name' => $user['nick_name'],
                'avatar' => $user['avatar'],
                'role' => $user['role'] ? $user['role']['name'] : '免费会员',
            ],
        ];
    }
}
