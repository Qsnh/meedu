<?php

/*
 * This file is part of the Qsnh/meedu.
 *
 * (c) 杭州白书科技有限公司
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
     * @api {get} /api/v2/courses 录播课程列表
     * @apiGroup 录播课
     * @apiVersion v2.0.0
     *
     * @apiParam {Number} page 页码
     * @apiParam {Number} page_size 每页条数
     * @apiParam {Number} category_id 分类ID
     * @apiParam {String=留空,recom,sub,free} [scene] 场景[空:全部课程,recom:推荐,sub:订阅最多,free:免费课程]
     *
     * @apiSuccess {Number} code 0成功,非0失败
     * @apiSuccess {Object[]} data 数据
     * @apiSuccess {Number} data.id 课程ID
     * @apiSuccess {String} data.title 课程名
     * @apiSuccess {String} data.thumb 封面
     * @apiSuccess {Number} data.charge 价格
     * @apiSuccess {String} data.short_description 简短介绍
     * @apiSuccess {String} data.render_desc 详细介绍
     * @apiSuccess {String} data.seo_keywords SEO关键字
     * @apiSuccess {String} data.seo_description SEO描述
     * @apiSuccess {String} data.published_at 上架时间
     * @apiSuccess {Number} data.is_rec 推荐[1:是,0否][已弃用]
     * @apiSuccess {Number} data.is_free 免费课程[1:是,0否]
     * @apiSuccess {Number} data.user_count 订阅人数
     * @apiSuccess {Number} data.videos_count 视频数
     * @apiSuccess {Object} data.category 分类
     * @apiSuccess {Number} data.category.id 分类ID
     * @apiSuccess {String} data.category.name 分类名
     */
    public function paginate(Request $request)
    {
        $categoryId = intval($request->input('category_id'));
        $scene = $request->input('scene', '');
        $page = $request->input('page', 1);
        $pageSize = $request->input('page_size', $this->configService->getCourseListPageSize());
        [
            'total' => $total,
            'list' => $list
        ] = $this->courseService->simplePage($page, $pageSize, $categoryId, $scene);

        $whitelistFields = array_flip(ApiV2Constant::MODEL_COURSE_FIELD);
        unset($whitelistFields['render_desc']);
        $whitelistFields = array_flip($whitelistFields);

        $list = arr2_clear($list, $whitelistFields);

        foreach ($list as $index => $item) {
            $list[$index]['category'] = arr1_clear($item['category'] ?? [], ApiV2Constant::MODEL_COURSE_CATEGORY_FIELD);
        }

        $courses = $this->paginator($list, $total, $page, $pageSize);

        return $this->data($courses->toArray());
    }

    /**
     * @api {get} /api/v2/course/{id} 录播课程详情
     * @apiGroup 录播课
     * @apiVersion v2.0.0
     *
     * @apiSuccess {Number} code 0成功,非0失败
     * @apiSuccess {Object[]} data 数据
     * @apiSuccess {Object} data.course 课程
     * @apiSuccess {Number} data.course.id 课程ID
     * @apiSuccess {String} data.course.title 课程名
     * @apiSuccess {String} data.course.thumb 封面
     * @apiSuccess {Number} data.course.charge 价格
     * @apiSuccess {String} data.course.short_description 简短介绍
     * @apiSuccess {String} data.course.render_desc 详细介绍
     * @apiSuccess {String} data.course.seo_keywords SEO关键字
     * @apiSuccess {String} data.course.seo_description SEO描述
     * @apiSuccess {String} data.course.published_at 上架时间
     * @apiSuccess {Number} data.course.is_rec 推荐[1:是,0否][已弃用]
     * @apiSuccess {Number} data.course.user_count 订阅人数
     * @apiSuccess {Number} data.course.videos_count 视频数
     * @apiSuccess {Object} data.course.category 分类
     * @apiSuccess {Number} data.course.category.id 分类ID
     * @apiSuccess {String} data.course.category.name 分类名
     * @apiSuccess {Object[]} data.chapters 章节
     * @apiSuccess {Number} data.chapters.id 章节ID
     * @apiSuccess {String} data.chapters.name 章节名
     * @apiSuccess {Object[]} data.videos 视频
     * @apiSuccess {Number} data.videos.id 视频ID
     * @apiSuccess {String} data.videos.title 视频名
     * @apiSuccess {Number} data.videos.charge 视频价格
     * @apiSuccess {Number} data.videos.view_num 观看数[已废弃]
     * @apiSuccess {String} data.videos.short_description 简短介绍
     * @apiSuccess {String} data.videos.render_desc 详细介绍[已废弃]
     * @apiSuccess {String} data.videos.published_at 上架时间
     * @apiSuccess {Number} data.videos.duration 时长[单位：秒]
     * @apiSuccess {String} data.videos.seo_keywords SEO关键字
     * @apiSuccess {String} data.videos.seo_description SEO描述
     * @apiSuccess {Number} data.videos.is_ban_sell 禁止出售[1:是,0否]
     * @apiSuccess {Number} data.videos.chapter_id 章节ID
     * @apiSuccess {Number} data.isBuy 购买[1:是,0否]
     * @apiSuccess {Number} data.isCollect 收藏[1:是,0否]
     * @apiSuccess {Object} data.videoWatchedProgress 视频进度
     * @apiSuccess {Number} data.videoWatchedProgress.id 记录ID
     * @apiSuccess {Number} data.videoWatchedProgress.user_id 用户ID
     * @apiSuccess {Number} data.videoWatchedProgress.course_id 课程ID
     * @apiSuccess {Number} data.videoWatchedProgress.video_id 视频ID
     * @apiSuccess {Number} data.videoWatchedProgress.watch_seconds 已观看秒数
     * @apiSuccess {String} data.videoWatchedProgress.watched_at 看完时间
     * @apiSuccess {Object[]} data.attach 附件
     * @apiSuccess {Number} data.attach.id 附件ID
     * @apiSuccess {Number} data.attach.size 附件大小[单位：字节]
     * @apiSuccess {String} data.attach.name 附件名
     * @apiSuccess {String} data.attach.extension 附件扩展名
     */
    public function detail($id)
    {
        $course = $this->courseService->find($id);
        $course = arr1_clear($course, ApiV2Constant::MODEL_COURSE_FIELD);

        // 章节列表
        $chapters = $this->courseService->chapters($course['id']);
        $chapters = arr2_clear($chapters, ApiV2Constant::MODEL_COURSE_CHAPTER_FIELD);

        // 视频列表
        $videos = $this->videoService->courseVideos($course['id']);
        $videos = arr2_clear($videos, ApiV2Constant::MODEL_VIDEO_FIELD, true);

        // 是否购买
        $isBuy = false;
        // 是否收藏
        $isCollect = false;
        // 课程视频观看进度
        $videoWatchedProgress = [];

        // 课程附件
        $attach = $this->courseService->getCourseAttach($course['id']);
        $attach = arr2_clear($attach, ApiV2Constant::MODEL_COURSE_ATTACH_FIELD);

        if ($this->check()) {
            $isBuy = $this->businessState->isBuyCourse($this->id(), $course['id']);
            $isCollect = $this->userService->likeCourseStatus($this->id(), $course['id']);

            $userVideoWatchRecords = $this->userService->getUserVideoWatchRecords($this->id(), $course['id']);
            $videoWatchedProgress = array_column($userVideoWatchRecords, null, 'video_id');
        }

        return $this->data(compact('course', 'chapters', 'videos', 'isBuy', 'isCollect', 'videoWatchedProgress', 'attach'));
    }

    /**
     * @api {post} /api/v2/course/{course_id}/comment 录播课程评论
     * @apiGroup 录播课
     * @apiVersion v2.0.0
     *
     * @apiParam {String} content 评论内容
     *
     * @apiSuccess {Number} code 0成功,非0失败
     * @apiSuccess {Object} data 数据
     */
    public function createComment(CommentRequest $request, $id)
    {
        $course = $this->courseService->find($id);
        if ($this->businessState->courseCanComment($this->user(), $course) == false) {
            return $this->error(__('课程无法评论'));
        }
        ['content' => $content] = $request->filldata();
        $this->courseCommentService->create($id, $content);
        return $this->success();
    }

    /**
     * @api {get} /api/v2/course/{course_id}/comments 录播课程评论列表
     * @apiGroup 录播课
     * @apiVersion v2.0.0
     *
     * @apiParam {Number} [page] 页码
     * @apiParam {Number} [page_size] 每页条数
     *
     * @apiSuccess {Number} code 0成功,非0失败
     * @apiSuccess {Object} data 数据
     * @apiSuccess {Object[]} data.comments 评论
     * @apiSuccess {Number} data.comments.id 评论ID
     * @apiSuccess {Number} data.comments.id 评论ID
     * @apiSuccess {Number} data.comments.user_id 用户ID
     * @apiSuccess {String} data.comments.render_content 评论内容
     * @apiSuccess {String} data.comments.created_at 时间
     * @apiSuccess {Object[]} data.users 用户
     * @apiSuccess {Number} data.users.id 用户ID
     * @apiSuccess {String} data.users.nick_name 用户昵称
     * @apiSuccess {String} data.users.avatar 用户头像
     * @apiSuccess {String} data.users.mobile 用户手机号
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

    /**
     * @api {get} /api/v2/course/{course_id}/like 收藏课程
     * @apiGroup 录播课
     * @apiVersion v2.0.0
     * @apiHeader Authorization Bearer+token
     *
     * @apiParam {String} content 评论内容
     *
     * @apiSuccess {Number} code 0成功,非0失败
     * @apiSuccess {Object} data 数据
     */
    public function like($id)
    {
        $course = $this->courseService->find($id);
        $status = $this->userService->likeACourse($this->id(), $course['id']);
        return $this->data($status);
    }

    /**
     * @api {get} /api/v2/course/attach/{attach_id}/download 附件下载
     * @apiGroup 录播课
     * @apiVersion v2.0.0
     *
     * @apiParam {String} token 登录token
     *
     * @apiSuccess {Number} code 0成功,非0失败
     * @apiSuccess {Object} data 数据
     */
    public function attachDownload($id)
    {
        $courseAttach = $this->courseService->getAttach($id);
        $course = $this->courseService->find($courseAttach['course_id']);

        if ($course['charge'] > 0 && !$this->businessState->isBuyCourse($this->id(), $courseAttach['course_id'])) {
            return $this->error(__('请购买课程'));
        }

        $this->courseService->courseAttachDownloadTimesInc($courseAttach['id']);

        return response()->download(storage_path('app/attach/' . $courseAttach['path']));
    }
}
