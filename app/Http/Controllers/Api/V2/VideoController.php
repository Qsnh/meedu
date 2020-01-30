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

use Illuminate\Http\Request;
use App\Constant\ApiV2Constant;
use App\Businesses\BusinessState;
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
        $this->videoService->viewNumInc($video['id']);
        $chapters = $this->courseService->chapters($video['course_id']);
        $chapters = arr2_clear($chapters, ApiV2Constant::MODEL_COURSE_CHAPTER_FIELD);
        $videos = $this->videoService->courseVideos($video['course_id']);
        $videos = arr2_clear($videos, ApiV2Constant::MODEL_VIDEO_FIELD, true);

        return $this->data([
            'video' => $video,
            'videos' => $videos,
            'chapters' => $chapters,
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
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function playInfo($id)
    {
        $video = $this->videoService->find($id);
        $course = $this->courseService->find($video['course_id']);
        if (!$this->businessState->canSeeVideo($this->user(), $course, $video)) {
            return $this->error(__(ApiV2Constant::VIDEO_NO_AUTH));
        }

        $urls = [];

        if ($video['url']) {
            // 直链
            $pathinfo = @pathinfo($video['url']);
            $urls = [
                [
                    'format' => $pathinfo['extension'] ?? '',
                    'url' => $video['url'],
                    'duration' => $video['duration'],
                ]
            ];
        } elseif ($video['aliyun_video_id']) {
            // 阿里云点播
            $urls = aliyun_play_url($video['aliyun_video_id']);
        } elseif ($video['tencent_video_id']) {
            // 腾讯云点播
            $urls = get_tencent_play_url($video['tencent_video_id']);
        }

        if (!$urls) {
            return $this->error(__('error'));
        }

        return $this->data(compact('urls'));
    }
}
