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

use Illuminate\Support\Arr;
use Illuminate\Http\Request;
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
 *         schema="Video",
 *         type="object",
 *         title="视频",
 *         @OA\Property(property="id",type="integer",description="视频ID"),
 *         @OA\Property(property="title",type="string",description="视频标题"),
 *         @OA\Property(property="slug",type="string",description="slug"),
 *         @OA\Property(property="charge",type="integer",description="视频价格"),
 *         @OA\Property(property="view_num",type="integer",description="观看次数"),
 *         @OA\Property(property="short_description",type="string",description="简短介绍"),
 *         @OA\Property(property="render_desc",type="string",description="详细介绍"),
 *         @OA\Property(property="published_at",type="string",description="上线时间"),
 *         @OA\Property(property="duration",type="integer",description="视频时长，单位：秒"),
 *     ),
 *     @OA\Schema(
 *         schema="VideoPlay",
 *         type="object",
 *         title="视频播放地址",
 *         @OA\Property(property="url",type="string",description="视频播放地址"),
 *         @OA\Property(property="extension",type="string",description="视频格式"),
 *     ),
 *     @OA\Schema(
 *         schema="VideoComment",
 *         type="object",
 *         title="视频评论",
 *         @OA\Property(property="user_id",type="integer",description="用户id"),
 *         @OA\Property(property="content",type="string",description="评论内容"),
 *     ),
 * )
 */

/**
 * Class VideoController
 * @package App\Http\Controllers\Api\V2
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
        $videos = $this->paginator($list, $total, $page, $pageSize);

        return $this->data($videos);
    }

    /**
     * @OA\Get(
     *     path="/video/{id}",
     *     @OA\Parameter(in="path",name="id",description="视频id",required=true,@OA\Schema(type="integer")),
     *     summary="视频信息",
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
        $videos = $this->videoService->courseVideos($video['course_id']);

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
        $comments = array_map(function ($item) {
            $item['content'] = $item['render_content'];
            return Arr::only($item, ['user_id', 'content']);
        }, $comments);
        $commentUsers = $this->userService->getList(array_column($comments, 'user_id'), ['role']);
        $commentUsers = array_column($commentUsers, null, 'id');

        return $this->data([
            'comments' => $comments,
            'users' => $commentUsers,
        ]);
    }

    public function playInfo()
    {
        // todo 视频播放信息
    }
}
