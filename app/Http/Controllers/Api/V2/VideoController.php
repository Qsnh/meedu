<?php

/*
 * This file is part of the Qsnh/meedu.
 *
 * (c) XiaoTeng <616896861@qq.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace App\Http\Controllers\Api\V2;

use App\Bus\VideoBus;
use App\Meedu\Cache\Inc\Inc;
use Illuminate\Http\Request;
use App\Constant\ApiV2Constant;
use App\Businesses\BusinessState;
use App\Meedu\Cache\Inc\VideoViewIncItem;
use App\Http\Requests\ApiV2\CommentRequest;
use App\Services\Base\Services\ConfigService;
use App\Services\Member\Services\UserService;
use App\Services\Order\Services\OrderService;
use App\Services\Course\Services\VideoService;
use App\Services\Course\Services\CourseService;
use App\Services\Course\Services\VideoCommentService;
use App\Services\Base\Interfaces\ConfigServiceInterface;
use App\Services\Member\Interfaces\UserServiceInterface;
use App\Services\Order\Interfaces\OrderServiceInterface;
use App\Services\Course\Interfaces\VideoServiceInterface;
use App\Services\Course\Interfaces\CourseServiceInterface;
use App\Services\Course\Interfaces\VideoCommentServiceInterface;

/**
 * @OpenApi\Annotations\Schemas(
 *     @OA\Schema(
 *         schema="PlayUrlItem",
 *         type="object",
 *         title="视频播放地址",
 *         @OA\Property(property="url",type="string",description="视频播放地址"),
 *         @OA\Property(property="format",type="string",description="视频格式"),
 *         @OA\Property(property="duration",type="integer",description="时长，秒"),
 *         @OA\Property(property="name",type="string",description="码率"),
 *     ),
 * )
 */

/**
 * Class VideoController
 * @package App\Http\Controllers\Api\V2
 *
 */
class VideoController extends BaseController
{

    /**
     * @var VideoService
     */
    protected $videoService;
    /**
     * @var ConfigService
     */
    protected $configService;
    /**
     * @var VideoCommentService
     */
    protected $videoCommentService;
    /**
     * @var UserService
     */
    protected $userService;
    /**
     * @var CourseService
     */
    protected $courseService;
    /**
     * @var BusinessState
     */
    protected $businessState;
    /**
     * @var OrderService
     */
    protected $orderService;

    public function __construct(
        VideoServiceInterface $videoService,
        ConfigServiceInterface $configService,
        VideoCommentServiceInterface $videoCommentService,
        UserServiceInterface $userService,
        CourseServiceInterface $courseService,
        BusinessState $businessState,
        OrderServiceInterface $orderService
    ) {
        $this->videoService = $videoService;
        $this->configService = $configService;
        $this->videoCommentService = $videoCommentService;
        $this->userService = $userService;
        $this->courseService = $courseService;
        $this->businessState = $businessState;
        $this->orderService = $orderService;
    }

    /**
     * @OA\Get(
     *     path="/videos",
     *     summary="视频列表",
     *     tags={"视频"},
     *     @OA\Parameter(in="query",name="page",description="页码",required=false,@OA\Schema(type="integer")),
     *     @OA\Parameter(in="query",name="page_size",description="每页数量",required=false,@OA\Schema(type="integer")),
     *     @OA\Response(
     *         description="",response=200,
     *         @OA\JsonContent(
     *             @OA\Property(property="code",type="integer",description="状态码"),
     *             @OA\Property(property="message",type="string",description="消息"),
     *             @OA\Property(property="data",type="object",description="",
     *                 @OA\Property(property="total",type="integer",description="总数"),
     *                 @OA\Property(property="data",type="array",description="数据列表",@OA\Items(ref="#/components/schemas/Video")),
     *             ),
     *         )
     *     )
     * )
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function paginate(Request $request)
    {
        $page = $request->input('page', 1);
        $pageSize = $request->input('page_size', $this->configService->getVideoListPageSize());
        [
            'list' => $list,
            'total' => $total
        ] = $this->videoService->simplePage($page, $pageSize);
        $list = arr2_clear($list, ApiV2Constant::MODEL_VIDEO_FIELD);
        $videos = $this->paginator($list, $total, $page, $pageSize);

        return $this->data($videos);
    }

    /**
     * @OA\Get(
     *     path="/video/{id}",
     *     @OA\Parameter(in="path",name="id",description="视频id",required=true,@OA\Schema(type="integer")),
     *     summary="视频信息",
     *     tags={"视频"},
     *     @OA\Response(
     *         description="",response=200,
     *         @OA\JsonContent(
     *             @OA\Property(property="code",type="integer",description="状态码"),
     *             @OA\Property(property="message",type="string",description="消息"),
     *             @OA\Property(property="data",type="object",description="",
     *                 @OA\Property(property="video",type="object",description="视频详情",ref="#/components/schemas/Video"),
     *                 @OA\Property(property="chapters",type="array",description="课程章节",@OA\Items(ref="#/components/schemas/CourseChapter")),
     *                 @OA\Property(property="videos",type="array",description="视频列表",@OA\Items(ref="#/components/schemas/Video")),
     *                 @OA\Property(property="course",type="object",description="课程",ref="#/components/schemas/Course"),
     *                 @OA\Property(property="is_watch",type="boolean",description="是否可以观看"),
     *             ),
     *         )
     *     )
     * )
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function detail($id)
    {
        $video = $this->videoService->find($id);

        // 视频浏览次数自增
        Inc::record(new VideoViewIncItem($video['id']));

        // 章节
        $chapters = $this->courseService->chapters($video['course_id']);
        $chapters = arr2_clear($chapters, ApiV2Constant::MODEL_COURSE_CHAPTER_FIELD);

        // 课程下视频列表
        $videos = $this->videoService->courseVideos($video['course_id']);
        $videos = arr2_clear($videos, ApiV2Constant::MODEL_VIDEO_FIELD, true);

        // 课程
        $course = $this->courseService->find($video['course_id']);

        // 是否可以观看
        $isWatch = false;
        // 课程视频观看进度
        $videoWatchedProgress = [];

        if ($this->check()) {
            $isWatch = $this->businessState->canSeeVideo($this->user(), $course, $video);
            // 记录观看人数
            $isWatch && $this->courseService->recordUserCount($this->id(), $course['id']);

            // 当前用户视频观看进度记录
            $userVideoWatchRecords = $this->userService->getUserVideoWatchRecords($this->id(), $course['id']);
            $videoWatchedProgress = array_column($userVideoWatchRecords, null, 'video_id');
        }

        $course = arr1_clear($course, ApiV2Constant::MODEL_COURSE_FIELD);
        $video = arr1_clear($video, ApiV2Constant::MODEL_VIDEO_FIELD);

        return $this->data([
            'video' => $video,
            'videos' => $videos,
            'chapters' => $chapters,
            'course' => $course,
            'is_watch' => $isWatch,
            'video_watched_progress' => $videoWatchedProgress,
        ]);
    }

    /**
     * @OA\Post(
     *     path="/video/{id}/comment",
     *     @OA\Parameter(in="path",name="id",description="视频id",required=true,@OA\Schema(type="integer")),
     *     summary="视频评论",
     *     tags={"视频"},
     *     @OA\RequestBody(description="",@OA\JsonContent(
     *         @OA\Property(property="content",description="评论内容",type="string"),
     *     )),
     *     @OA\Response(
     *         description="",response=200,
     *         @OA\JsonContent(
     *             @OA\Property(property="code",type="integer",description="状态码"),
     *             @OA\Property(property="message",type="string",description="消息"),
     *             @OA\Property(property="data",type="object",description=""),
     *         )
     *     )
     * )
     * @param CommentRequest $request
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function createComment(CommentRequest $request, $id)
    {
        $video = $this->videoService->find($id);
        if ($this->businessState->videoCanComment($this->user(), $video) === false) {
            return $this->error(__('video cant comment'));
        }
        ['content' => $content] = $request->filldata();
        $this->videoCommentService->create($id, $content);
        return $this->success();
    }

    /**
     * @OA\Get(
     *     path="/video/{id}/comments",
     *     @OA\Parameter(in="path",name="id",description="视频id",required=true,@OA\Schema(type="integer")),
     *     @OA\Parameter(in="query",name="page",description="页码",required=false,@OA\Schema(type="integer")),
     *     @OA\Parameter(in="query",name="page_size",description="每页数量",required=false,@OA\Schema(type="integer")),
     *     summary="视频评论列表",
     *     tags={"视频"},
     *     @OA\Response(
     *         description="",response=200,
     *         @OA\JsonContent(
     *             @OA\Property(property="code",type="integer",description="状态码"),
     *             @OA\Property(property="message",type="string",description="消息"),
     *             @OA\Property(property="data",type="object",description="",
     *                 @OA\Property(property="comments",type="array",description="评论",@OA\Items(ref="#/components/schemas/VideoComment")),
     *                 @OA\Property(property="users",type="array",description="评论用户",@OA\Items(ref="#/components/schemas/User")),
     *             ),
     *         )
     *     )
     * )
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function comments($id)
    {
        $comments = $this->videoCommentService->videoComments($id);
        $comments = arr2_clear($comments, ApiV2Constant::MODEL_VIDEO_COMMENT_FIELD);
        $commentUsers = $this->userService->getList(array_column($comments, 'user_id'), ['role']);
        $commentUsers = arr2_clear($commentUsers, ApiV2Constant::MODEL_MEMBER_FIELD);
        $commentUsers = array_column($commentUsers, null, 'id');

        return $this->data([
            'comments' => $comments,
            'users' => $commentUsers,
        ]);
    }

    /**
     * @OA\Get(
     *     path="/video/{id}/playinfo",
     *     @OA\Parameter(in="path",name="id",description="视频id",required=true,@OA\Schema(type="integer")),
     *      @OA\Parameter(in="query",name="is_try",description="试看",required=false,@OA\Schema(type="integer")),
     *     summary="视频播放地址",
     *     tags={"视频"},
     *     @OA\Response(
     *         description="",response=200,
     *         @OA\JsonContent(
     *             @OA\Property(property="code",type="integer",description="状态码"),
     *             @OA\Property(property="message",type="string",description="消息"),
     *             @OA\Property(property="data",type="object",description="",
     *                 @OA\Property(property="urls",type="array",description="播放地址",@OA\Items(ref="#/components/schemas/PlayUrlItem")),
     *             ),
     *         )
     *     )
     * )
     * @param Request $request
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function playInfo(Request $request, $id)
    {
        $isTry = $request->has('is_try');

        $video = $this->videoService->find($id);
        $course = $this->courseService->find($video['course_id']);
        if (!$this->businessState->canSeeVideo($this->user(), $course, $video)) {
            return $this->error(__(ApiV2Constant::VIDEO_NO_AUTH));
        }

        $urls = get_play_url($video, $isTry);

        if (!$urls) {
            return $this->error(__('error'));
        }

        return $this->data(compact('urls'));
    }

    /**
     * @OA\Post(
     *     path="/video/{id}/record",
     *     @OA\Parameter(in="path",name="id",description="视频id",required=true,@OA\Schema(type="integer")),
     *     summary="视频观看时长记录",
     *     tags={"视频"},
     *     @OA\RequestBody(description="",@OA\JsonContent(
     *         @OA\Property(property="duration",description="时长",type="integer"),
     *     )),
     *     @OA\Response(
     *         description="",response=200,
     *         @OA\JsonContent(
     *             @OA\Property(property="code",type="integer",description="状态码"),
     *             @OA\Property(property="message",type="string",description="消息"),
     *             @OA\Property(property="data",type="object",description=""),
     *         )
     *     )
     * )
     */
    public function recordVideo(Request $request, VideoBus $videoBus, $id)
    {
        // 视频已观看时长
        $duration = (int)$request->post('duration', 0);
        if (!$duration) {
            return $this->error(__('params error'));
        }

        $videoBus->userVideoWatchDurationRecord($this->id(), (int)$id, $duration);

        return $this->success();
    }
}
