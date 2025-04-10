<?php

/*
 * This file is part of the MeEdu.
 *
 * (c) 杭州白书科技有限公司
 */

namespace App\Http\Controllers\Api\V2;

use Illuminate\Http\Request;
use App\Constant\ApiV2Constant;
use App\Businesses\BusinessState;
use App\Services\Member\Services\UserService;
use App\Services\Course\Services\VideoService;
use App\Services\Course\Services\CourseService;
use App\Services\Member\Interfaces\UserServiceInterface;
use App\Services\Course\Interfaces\VideoServiceInterface;
use App\Services\Course\Interfaces\CourseServiceInterface;

class CourseController extends BaseController
{

    /**
     * @var CourseService
     */
    protected $courseService;

    /**
     * @var UserService
     */
    protected $userService;
    /**
     * @var VideoService
     */
    protected $videoService;

    /**
     * @var BusinessState
     */
    protected $businessState;

    public function __construct(
        CourseServiceInterface        $courseService,
        UserServiceInterface          $userService,
        VideoServiceInterface         $videoService,
        BusinessState                 $businessState
    ) {
        $this->courseService = $courseService;
        $this->userService = $userService;
        $this->videoService = $videoService;
        $this->businessState = $businessState;
    }

    /**
     * @api {get} /api/v2/courses [V2]录播课-列表
     * @apiGroup 录播课模块
     * @apiName Courses
     *
     * @apiParam {Number} [page] page
     * @apiParam {Number} [page_size] page_size
     * @apiParam {Number} [category_id] 分类ID
     * @apiParam {String=sub,free} [scene] 场景[sub:购买最多,free:免费课程]
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
     * @apiSuccess {Number} data.user_count 购买人数
     * @apiSuccess {Number} data.videos_count 视频数
     * @apiSuccess {Object} data.category 分类
     * @apiSuccess {Number} data.category.id 分类ID
     * @apiSuccess {String} data.category.name 分类名
     */
    public function paginate(Request $request)
    {
        $categoryId = intval($request->input('category_id'));
        $scene = $request->input('scene', '');

        $page = (int)$request->input('page', 1);
        $pageSize = (int)$request->input('page_size', 16);

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
     * @api {get} /api/v2/course/{id} [V2]录播课-详情
     * @apiGroup 录播课模块
     * @apiName CourseDetail
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
     * @apiSuccess {Number} data.course.user_count 购买人数
     * @apiSuccess {Number} data.course.videos_count 视频数
     * @apiSuccess {Number} data.course.is_allow_comment 是否允许评论[1:是,0:否]
     * @apiSuccess {Object} data.course.category 分类
     * @apiSuccess {Number} data.course.category.id 分类ID
     * @apiSuccess {String} data.course.category.name 分类名
     * @apiSuccess {Object[]} data.chapters 章节
     * @apiSuccess {Number} data.chapters.id 章节ID
     * @apiSuccess {String} data.chapters.title 章节名
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
     * @apiSuccess {Number[]} data.buyVideos 已购视频ID
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

        // 用户已购视频
        $buyVideos = [];

        if ($this->check()) {
            $isBuy = $this->businessState->isBuyCourse($this->id(), $course['id']);
            $isCollect = $this->userService->likeCourseStatus($this->id(), $course['id']);

            $userVideoWatchRecords = $this->userService->getUserVideoWatchRecords($this->id(), $course['id']);
            $videoWatchedProgress = array_column($userVideoWatchRecords, null, 'video_id');

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

        return $this->data(compact(
            'course',
            'chapters',
            'videos',
            'isBuy',
            'isCollect',
            'videoWatchedProgress',
            'attach',
            'buyVideos',
        ));
    }

    /**
     * @api {get} /api/v2/course/{courseId}/like [V2]录播课-收藏
     * @apiGroup 录播课模块
     * @apiName CourseLikeAction
     * @apiHeader Authorization Bearer+空格+token
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
     * @api {get} /api/v2/course/attach/{attach_id}/download [V2]录播课-附件-下载
     * @apiGroup 录播课模块
     * @apiName CourseAttachDownload
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
