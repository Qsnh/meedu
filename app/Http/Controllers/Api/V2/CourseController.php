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
 * @OpenApi\Annotations\Schemas(
 *     @OA\Schema(
 *         schema="Course",
 *         type="object",
 *         title="课程",
 *         @OA\Property(property="id",type="integer",description="课程id"),
 *         @OA\Property(property="title",type="string",description="课程标题"),
 *         @OA\Property(property="slug",type="string",description="slug"),
 *         @OA\Property(property="thumb",type="string",description="课程封面"),
 *         @OA\Property(property="charge",type="integer",description="课程价格"),
 *         @OA\Property(property="short_description",type="string",description="简短介绍"),
 *         @OA\Property(property="render_desc",type="string",description="详细介绍"),
 *         @OA\Property(property="published_at",type="string",description="上线时间"),
 *     ),
 *     @OA\Schema(
 *         schema="CourseChapter",
 *         type="object",
 *         title="课程章节",
 *         @OA\Property(property="course_id",type="integer",description="课程id"),
 *         @OA\Property(property="title",type="string",description="章节名"),
 *         @OA\Property(property="sort",type="string",description="升序"),
 *     ),
 *     @OA\Schema(
 *         schema="CourseComment",
 *         type="object",
 *         title="课程评论",
 *         @OA\Property(property="user_id",type="integer",description="用户id"),
 *         @OA\Property(property="content",type="string",description="评论内容"),
 *     ),
 * )
 */

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

    public function __construct(
        CourseServiceInterface $courseService,
        ConfigServiceInterface $configService,
        CourseCommentServiceInterface $courseCommentService,
        UserServiceInterface $userService,
        VideoServiceInterface $videoService,
        OrderServiceInterface $orderService
    ) {
        $this->courseService = $courseService;
        $this->configService = $configService;
        $this->courseCommentService = $courseCommentService;
        $this->userService = $userService;
        $this->videoService = $videoService;
        $this->orderService = $orderService;
    }

    /**
     * @OA\Get(
     *     path="/courses",
     *     summary="课程列表",
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
        $courses = $this->paginator($list, $total, $page, $pageSize);

        return $this->data($courses->toArray());
    }

    /**
     * @OA\Get(
     *     path="/course/{id}",
     *     @OA\Parameter(in="path",name="id",description="课程id",required=true,@OA\Schema(type="integer")),
     *     summary="课程信息",
     *     @OA\Response(
     *         description="",response=200,
     *         @OA\JsonContent(
     *             @OA\Property(property="code",type="integer",description="状态码"),
     *             @OA\Property(property="message",type="string",description="消息"),
     *             @OA\Property(property="data",type="object",description="",
     *                 @OA\Property(property="course",type="object",description="课程详情",ref="#/components/schemas/Course"),
     *                 @OA\Property(property="chapters",type="array",description="课程章节",@OA\Items(ref="#/components/schemas/CourseChapter")),
     *                 @OA\Property(property="videos",type="array",description="视频",@OA\Items(ref="#/components/schemas/Video")),
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
        $chapters = $this->courseService->chapters($course['id']);
        $videos = $this->videoService->courseVideos($course['id']);

        return $this->data(compact('course', 'chapters', 'videos'));
    }

    /**
     * @OA\Post(
     *     path="/course/{id}/comment",
     *     @OA\Parameter(in="path",name="id",description="课程id",required=true,@OA\Schema(type="integer")),
     *     summary="课程评论",
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
}
