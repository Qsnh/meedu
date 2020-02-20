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
use App\Services\Course\Services\CourseCommentService;
use App\Services\Base\Interfaces\ConfigServiceInterface;
use App\Services\Member\Interfaces\UserServiceInterface;
use App\Services\Order\Interfaces\OrderServiceInterface;
use App\Services\Course\Interfaces\VideoServiceInterface;
use App\Services\Course\Interfaces\CourseServiceInterface;
use App\Services\Course\Interfaces\CourseCommentServiceInterface;

/**
 * Class CourseController
 * @package App\Http\Controllers\Api\V2
 */
class CourseController extends BaseController
{

    /**
     * @var CourseService
     */
    protected $courseService;
    /**
     * @var ConfigService
     */
    protected $configService;
    /**
     * @var CourseCommentService
     */
    protected $courseCommentService;
    /**
     * @var UserService
     */
    protected $userService;
    /**
     * @var VideoService
     */
    protected $videoService;
    /**
     * @var OrderService
     */
    protected $orderService;

    /**
     * @var BusinessState
     */
    protected $businessState;

    public function __construct(
        CourseServiceInterface $courseService,
        ConfigServiceInterface $configService,
        CourseCommentServiceInterface $courseCommentService,
        UserServiceInterface $userService,
        VideoServiceInterface $videoService,
        OrderServiceInterface $orderService,
        BusinessState $businessState
    ) {
        $this->courseService = $courseService;
        $this->configService = $configService;
        $this->courseCommentService = $courseCommentService;
        $this->userService = $userService;
        $this->videoService = $videoService;
        $this->orderService = $orderService;
        $this->businessState = $businessState;
    }

    /**
     * @OA\Get(
     *     path="/courses",
     *     summary="课程列表",
     *     tags={"课程"},
     *     @OA\Parameter(in="query",name="page",description="页码",required=false,@OA\Schema(type="integer")),
     *     @OA\Parameter(in="query",name="page_size",description="每页数量",required=false,@OA\Schema(type="integer")),
     *     @OA\Parameter(in="query",name="category_id",description="分类id",required=false,@OA\Schema(type="integer")),
     *     @OA\Response(
     *         description="",response=200,
     *         @OA\JsonContent(
     *             @OA\Property(property="code",type="integer",description="状态码"),
     *             @OA\Property(property="message",type="string",description="消息"),
     *             @OA\Property(property="data",type="object",description="",
     *                 @OA\Property(property="total",type="integer",description="总数"),
     *                 @OA\Property(property="data",type="array",description="数据列表",@OA\Items(ref="#/components/schemas/Course")),
     *             ),
     *         )
     *     )
     * )
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function paginate(Request $request)
    {
        $categoryId = intval($request->input('category_id'));
        $page = $request->input('page', 1);
        $pageSize = $request->input('page_size', $this->configService->getCourseListPageSize());
        [
            'total' => $total,
            'list' => $list
        ] = $this->courseService->simplePage($page, $pageSize, $categoryId);
        $list = arr2_clear($list, ApiV2Constant::MODEL_COURSE_FIELD);
        $courses = $this->paginator($list, $total, $page, $pageSize);

        return $this->data($courses->toArray());
    }

    /**
     * @OA\Get(
     *     path="/course/{id}",
     *     @OA\Parameter(in="path",name="id",description="课程id",required=true,@OA\Schema(type="integer")),
     *     summary="课程信息",
     *     tags={"课程"},
     *     @OA\Response(
     *         description="",response=200,
     *         @OA\JsonContent(
     *             @OA\Property(property="code",type="integer",description="状态码"),
     *             @OA\Property(property="message",type="string",description="消息"),
     *             @OA\Property(property="data",type="object",description="",
     *                 @OA\Property(property="course",type="object",description="课程详情",ref="#/components/schemas/Course"),
     *                 @OA\Property(property="chapters",type="array",description="课程章节",@OA\Items(ref="#/components/schemas/CourseChapter")),
     *                 @OA\Property(property="videos",type="array",description="视频",@OA\Items(ref="#/components/schemas/Video")),
     *                 @OA\Property(property="isBuy",type="bool",description="是否购买"),
     *             ),
     *         )
     *     )
     * )
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function detail($id)
    {
        $course = $this->courseService->find($id);
        $course = arr1_clear($course, ApiV2Constant::MODEL_COURSE_FIELD);
        $chapters = $this->courseService->chapters($course['id']);
        $chapters = arr2_clear($chapters, ApiV2Constant::MODEL_COURSE_CHAPTER_FIELD);
        $videos = $this->videoService->courseVideos($course['id']);
        $videos = arr2_clear($videos, ApiV2Constant::MODEL_VIDEO_FIELD, true);
        $isBuy = $this->businessState->isBuyCourse($course['id']);

        return $this->data(compact('course', 'chapters', 'videos', 'isBuy'));
    }

    /**
     * @OA\Post(
     *     path="/course/{id}/comment",
     *     @OA\Parameter(in="path",name="id",description="课程id",required=true,@OA\Schema(type="integer")),
     *     summary="课程评论",
     *     tags={"课程"},
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
        $this->courseCommentService->create($id, $content);
        return $this->success();
    }

    /**
     * @OA\Get(
     *     path="/course/{id}/comments",
     *     @OA\Parameter(in="query",name="page",description="页码",required=false,@OA\Schema(type="integer")),
     *     @OA\Parameter(in="query",name="page_size",description="每页数量",required=false,@OA\Schema(type="integer")),
     *     @OA\Parameter(in="path",name="id",description="课程id",required=true,@OA\Schema(type="integer")),
     *     summary="课程评论列表",
     *     tags={"课程"},
     *     @OA\Response(
     *         description="",response=200,
     *         @OA\JsonContent(
     *             @OA\Property(property="code",type="integer",description="状态码"),
     *             @OA\Property(property="message",type="string",description="消息"),
     *             @OA\Property(property="data",type="object",description="",
     *                 @OA\Property(property="comments",type="array",description="评论",@OA\Items(ref="#/components/schemas/CourseComment")),
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
        $comments = $this->courseCommentService->courseComments($id);
        $comments = arr2_clear($comments, ApiV2Constant::MODEL_COURSE_COMMENT_FIELD);
        $commentUsers = $this->userService->getList(array_column($comments, 'user_id'), ['role']);
        $commentUsers = arr2_clear($commentUsers, ApiV2Constant::MODEL_MEMBER_FIELD);
        $commentUsers = array_column($commentUsers, null, 'id');

        return $this->data([
            'comments' => $comments,
            'users' => $commentUsers,
        ]);
    }
}
