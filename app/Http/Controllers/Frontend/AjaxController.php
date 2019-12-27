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
use App\Services\Member\Interfaces\UserServiceInterface;
use App\Services\Course\Interfaces\VideoServiceInterface;
use App\Services\Course\Interfaces\CourseServiceInterface;
use App\Services\Course\Interfaces\VideoCommentServiceInterface;
use App\Http\Requests\Frontend\CourseOrVideoCommentCreateRequest;
use App\Services\Course\Interfaces\CourseCommentServiceInterface;

class AjaxController extends Controller
{
    protected $videoCommentService;
    protected $courseCommentService;
    protected $userService;
    protected $courseService;
    protected $videoService;

    public function __construct(
        VideoCommentServiceInterface $videoCommentService,
        CourseCommentServiceInterface $courseCommentService,
        UserServiceInterface $userService,
        VideoServiceInterface $videoService,
        CourseServiceInterface $courseService
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
        $comment = $this->courseCommentService->create($course['id'], $content);
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
        $comment = $this->videoCommentService->create($video['id'], $content);
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
