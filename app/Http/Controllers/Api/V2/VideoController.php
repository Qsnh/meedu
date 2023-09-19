<?php

/*
 * This file is part of the MeEdu.
 *
 * (c) 杭州白书科技有限公司
 */

namespace App\Http\Controllers\Api\V2;

use App\Bus\VideoBus;
use App\Meedu\Cache\Inc\Inc;
use Illuminate\Http\Request;
use App\Constant\ApiV2Constant;
use App\Businesses\BusinessState;
use App\Constant\FrontendConstant;
use App\Meedu\Cache\Inc\VideoViewIncItem;
use App\Http\Requests\ApiV2\CommentRequest;
use App\Services\Member\Services\UserService;
use App\Services\Order\Services\OrderService;
use App\Services\Course\Services\VideoService;
use App\Services\Course\Services\CourseService;
use App\Services\Course\Services\VideoCommentService;
use App\Services\Base\Interfaces\ConfigServiceInterface;
use App\Services\Member\Interfaces\UserServiceInterface;
use App\Services\Order\Interfaces\OrderServiceInterface;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use App\Services\Course\Interfaces\VideoServiceInterface;
use App\Services\Course\Interfaces\CourseServiceInterface;
use App\Services\Course\Interfaces\VideoCommentServiceInterface;

class VideoController extends BaseController
{

    /**
     * @var VideoService
     */
    protected $videoService;

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
        VideoServiceInterface        $videoService,
        ConfigServiceInterface       $configService,
        VideoCommentServiceInterface $videoCommentService,
        UserServiceInterface         $userService,
        CourseServiceInterface       $courseService,
        BusinessState                $businessState,
        OrderServiceInterface        $orderService
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
     * @api {get} /api/v2/videos 录播视频列表
     * @apiGroup 录播课
     * @apiName Videos
     * @apiVersion v2.0.0
     *
     * @apiSuccess {Number} code 0成功,非0失败
     * @apiSuccess {Object} data
     * @apiSuccess {Number} data.total 总数
     * @apiSuccess {Object[]} data.data
     * @apiSuccess {Number} data.data.id 视频ID
     * @apiSuccess {String} data.data.title 视频名
     * @apiSuccess {Number} data.data.charge 视频价格
     * @apiSuccess {Number} data.data.view_num 观看数[已废弃]
     * @apiSuccess {String} data.data.short_description 简短介绍
     * @apiSuccess {String} data.data.render_desc 详细介绍[已废弃]
     * @apiSuccess {String} data.data.published_at 上架时间
     * @apiSuccess {Number} data.data.duration 时长[单位：秒]
     * @apiSuccess {String} data.data.seo_keywords SEO关键字
     * @apiSuccess {String} data.data.seo_description SEO描述
     * @apiSuccess {Number} data.data.is_ban_sell 禁止出售[1:是,0否]
     * @apiSuccess {Number} data.data.chapter_id 章节ID
     */
    public function paginate(Request $request)
    {
        $page = $request->input('page', 1);
        $pageSize = $request->input('page_size', 10);
        [
            'list' => $list,
            'total' => $total
        ] = $this->videoService->simplePage($page, $pageSize);
        $list = arr2_clear($list, ApiV2Constant::MODEL_VIDEO_FIELD);
        $videos = $this->paginator($list, $total, $page, $pageSize);

        return $this->data($videos);
    }

    /**
     * @api {get} /api/v2//video/{id} 录播视频详情
     * @apiGroup 录播课
     * @apiName VideoDetail
     * @apiVersion v2.0.0
     *
     * @apiSuccess {Number} code 0成功,非0失败
     * @apiSuccess {Object} data
     * @apiSuccess {Object} data.video
     * @apiSuccess {Number} data.video.id 视频ID
     * @apiSuccess {String} data.video.title 视频名
     * @apiSuccess {Number} data.video.charge 视频价格
     * @apiSuccess {Number} data.video.view_num 观看次数
     * @apiSuccess {String} data.video.short_description 简短介绍
     * @apiSuccess {String} data.video.published_at 上架时间
     * @apiSuccess {Number} data.video.duration 时长[单位：秒]
     * @apiSuccess {String} data.video.seo_keywords SEO关键字
     * @apiSuccess {String} data.video.seo_description SEO描述
     * @apiSuccess {Number} data.video.is_ban_sell 禁止出售[1:是,0否]
     * @apiSuccess {Number} data.video.ban_drag 禁止拖拽播放[1:是,0否]
     * @apiSuccess {Number} data.video.chapter_id 章节ID
     * @apiSuccess {Object[]} data.videos
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
     * @apiSuccess {Number} data.videos.ban_drag 禁止拖拽播放[1:是,0否]
     * @apiSuccess {Number} data.videos.chapter_id 章节ID
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
     * @apiSuccess {Number} data.is_watch 是否可以观看[1:是,0否]
     * @apiSuccess {Object} data.videoWatchedProgress 视频进度
     * @apiSuccess {Number} data.videoWatchedProgress.id 记录ID
     * @apiSuccess {Number} data.videoWatchedProgress.user_id 用户ID
     * @apiSuccess {Number} data.videoWatchedProgress.course_id 课程ID
     * @apiSuccess {Number} data.videoWatchedProgress.video_id 视频ID
     * @apiSuccess {Number} data.videoWatchedProgress.watch_seconds 已观看秒数
     * @apiSuccess {String} data.videoWatchedProgress.watched_at 看完时间
     * @apiSuccess {Number[]} data.buy_videos 已购视频ID
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

        // 已购视频
        $buyVideos = [];

        if ($this->check()) {
            $isWatch = $this->businessState->canSeeVideo($this->user(), $course, $video);
            // 记录观看人数
            $isWatch && $this->courseService->createCourseUserRecord($this->id(), $course['id']);

            // 当前用户视频观看进度记录
            $userVideoWatchRecords = $this->userService->getUserVideoWatchRecords($this->id(), $course['id']);
            $videoWatchedProgress = array_column($userVideoWatchRecords, null, 'video_id');

            // 已购视频
            $videoIds = [];
            foreach ($videos as $childrenItem) {
                foreach ($childrenItem as $videoItem) {
                    $videoIds[] = $videoItem['id'];
                }
            }
            if ($videoIds) {
                $buyVideos = $this->userService->getUserBuyVideosIn($this->id(), $videoIds);
            }
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
            'buy_videos' => $buyVideos,
        ]);
    }

    /**
     * @api {post} /api/v2/video/{id}/comment 录播视频评论
     * @apiGroup 录播课
     * @apiName VideoCommentAction
     * @apiVersion v2.0.0
     * @apiHeader Authorization Bearer+空格+token
     *
     * @apiParam {String} content 评论内容
     *
     * @apiSuccess {Number} code 0成功,非0失败
     * @apiSuccess {Object} data 数据
     */
    public function createComment(CommentRequest $request, $id)
    {
        $video = $this->videoService->find($id);
        if ($this->businessState->videoCanComment($this->user(), $video) === false) {
            return $this->error(__('无权限'));
        }

        ['content' => $content] = $request->filldata();
        if (!$content) {
            return $this->error(__('参数错误'));
        }

        $this->videoCommentService->create($this->id(), $id, $content);

        return $this->success();
    }

    /**
     * @api {get} /api/v2/video/{video_id}/comments 录播视频评论列表
     * @apiGroup 录播课
     * @apiName VideoComments
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
     */
    public function comments($id)
    {
        $comments = $this->videoCommentService->videoComments($id);
        $comments = arr2_clear($comments, ApiV2Constant::MODEL_VIDEO_COMMENT_FIELD);
        $commentUsers = $this->userService->getList(array_column($comments, 'user_id'), ['role']);

        $commentUsers = arr2_clear($commentUsers, ApiV2Constant::MODEL_MEMBER_SIMPLE);
        $commentUsers = array_column($commentUsers, null, 'id');

        return $this->data([
            'comments' => $comments,
            'users' => $commentUsers,
        ]);
    }

    /**
     * @api {get} /api/v2/video/{id}/playinfo 录播视频播放地址
     * @apiGroup 录播课
     * @apiName VideoPlay
     * @apiVersion v2.0.0
     * @apiHeader Authorization Bearer+空格+token
     *
     * @apiParam {Number} is_try 是否试看[1:是,0否]
     *
     * @apiSuccess {Number} code 0成功,非0失败
     * @apiSuccess {Object} data 数据
     * @apiSuccess {String} data.url 播放URL
     * @apiSuccess {String} data.format 视频格式
     * @apiSuccess {Number} data.duration 时长,单位:秒
     * @apiSuccess {String} data.name 清晰度
     */
    public function playInfo(Request $request, $id)
    {
        $isTry = (int)$request->has('is_try');

        $video = $this->videoService->find($id);
        $course = $this->courseService->find($video['course_id']);

        // 如果视频未配置试看秒数那么是无法试看的
        $video['free_seconds'] <= 0 && $isTry = false;

        // 当前用户是否可以观看视频
        $canSee = $this->businessState->canSeeVideo($this->user(), $course, $video);

        // 如果用户可以观看视频就无需试看
        $canSee && $isTry = false;

        // 无法观看且也没有配置试看 => 将无法观看
        if ($canSee === false && !$isTry) {
            return $this->error(__('请购买后观看'));
        }

        $urls = get_play_url($video, $isTry);
        if (!$urls) {
            return $this->error(__('错误'));
        }

        return $this->data(compact('urls'));
    }

    /**
     * @api {post} /api/v2/video/{id}/record 视频观看时长记录
     * @apiGroup 录播课
     * @apiName VideoRecordAction
     * @apiVersion v2.0.0
     * @apiHeader Authorization Bearer+空格+token
     *
     * @apiParam {Number} duration 已观看时长,单位：秒
     *
     * @apiSuccess {Number} code 0成功,非0失败
     * @apiSuccess {Object} data 数据
     */
    public function recordVideo(Request $request, VideoBus $videoBus, $id)
    {
        // 视频已观看时长
        $duration = (int)$request->post('duration', 0);
        if (!$duration) {
            return $this->error(__('参数错误'));
        }

        $videoBus->userVideoWatchDurationRecord($this->id(), (int)$id, $duration);

        return $this->success();
    }

    /**
     * @api {get} /api/v2/video/open/play 公共视频播放
     * @apiGroup 录播课
     * @apiName VideoOpenPlay
     * @apiVersion v2.0.0
     *
     * @apiParam {String} file_id 视频文件ID
     * @apiParam {String} service 视频文件存储服务
     *
     * @apiSuccess {Number} code 0成功,非0失败
     * @apiSuccess {Object} data 数据
     * @apiSuccess {String} data.url 播放URL
     * @apiSuccess {String} data.format 视频格式
     * @apiSuccess {Number} data.duration 时长,单位:秒
     * @apiSuccess {String} data.name 清晰度
     */
    public function openPlay(Request $request)
    {
        $fileId = $request->input('file_id');
        $service = $request->input('service');

        if (!$fileId || !$service) {
            return $this->error(__('参数错误'));
        }

        $mediaVideo = $this->videoService->findOpenVideo($fileId, $service);
        throw_if(!$mediaVideo, ModelNotFoundException::class);

        $urls = get_play_url([
            'aliyun_video_id' => $mediaVideo['storage_driver'] === FrontendConstant::VOD_SERVICE_ALIYUN ? $mediaVideo['storage_file_id'] : '',
            'tencent_video_id' => $mediaVideo['storage_driver'] === FrontendConstant::VOD_SERVICE_TENCENT ? $mediaVideo['storage_file_id'] : '',
            'url' => '',
        ], false);

        if (!$urls) {
            return $this->error(__('错误'));
        }

        return $this->data(compact('urls'));
    }
}
