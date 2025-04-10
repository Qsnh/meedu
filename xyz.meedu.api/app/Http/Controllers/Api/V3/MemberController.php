<?php

/*
 * This file is part of the MeEdu.
 *
 * (c) 杭州白书科技有限公司
 */

namespace App\Http\Controllers\Api\V3;

use Carbon\Carbon;
use App\Bus\MemberBus;
use App\Bus\UploadBus;
use App\Meedu\Tencent\Face;
use Illuminate\Http\Request;
use App\Constant\BusConstant;
use App\Constant\CacheConstant;
use App\Exceptions\ServiceException;
use Illuminate\Support\Facades\Cache;
use App\Events\UserVerifyFaceSuccessEvent;
use App\Http\Controllers\Api\V2\BaseController;
use App\Meedu\ServiceV2\Services\UserServiceInterface;
use App\Meedu\ServiceV2\Services\CourseServiceInterface;

class MemberController extends BaseController
{

    /**
     * @api {get} /api/v3/member/courses [V3]学员-录播课-已购-列表
     * @apiGroup 学员
     * @apiName MemberCoursesV3
     * @apiHeader Authorization Bearer+空格+token
     *
     * @apiParam {Number} page 页码
     * @apiParam {Number} size 每页数量
     *
     * @apiSuccess {Number} code 0成功,非0失败
     * @apiSuccess {Object} data 数据
     * @apiSuccess {Number} data.total 总数
     * @apiSuccess {Object[]} data.data
     * @apiSuccess {Number} data.data.course_id 课程ID
     * @apiSuccess {Number} data.data.user_id 用户ID
     * @apiSuccess {Number} data.data.charge 购买价格
     * @apiSuccess {String} data.data.created_at 购买时间
     * @apiSuccess {Number} data.data.learned_count 已学习课时
     * @apiSuccess {Object} data.data.watch_record 观看进度记录
     * @apiSuccess {Number} data.data.watch_record.id 记录ID
     * @apiSuccess {Number} data.data.watch_record.is_watched 是否看完[1:是,0:否]
     * @apiSuccess {String} data.data.watch_record.watched_at 看完时间
     * @apiSuccess {Number} data.data.watch_record.progress 进度[0-100]
     * @apiSuccess {String} data.data.watch_record.created_at 观看开始时间
     * @apiSuccess {String} data.data.watch_record.updated_at 最近观看时间
     * @apiSuccess {Object} data.data.course 课程
     * @apiSuccess {String} data.data.course.title 课程名
     * @apiSuccess {String} data.data.course.thumb 课程封面
     * @apiSuccess {Number} data.data.course.videos_count 总课时
     * @apiSuccess {Number} data.data.course.charge 价格
     * @apiSuccess {Object} data.data.last_view_video 最近观看的视频记录
     * @apiSuccess {Number} data.data.last_view_video.id 记录id
     * @apiSuccess {Number} data.data.last_view_video.video_id videoId
     * @apiSuccess {Number} data.data.last_view_video.watch_seconds 已观看秒数
     * @apiSuccess {String} data.data.last_view_video.created_at 观看开始时间
     * @apiSuccess {String} data.data.last_view_video.updated_at 最近一次观看时间
     * @apiSuccess {String} data.data.last_view_video.watched_at 看完时间
     * @apiSuccess {Object} data.data.last_view_video.video
     * @apiSuccess {Number} data.data.last_view_video.video.id videoId
     * @apiSuccess {String} data.data.last_view_video.video.title 视频名
     * @apiSuccess {Number} data.data.last_view_video.video.duration 视频时长[s]
     * @apiSuccess {String} data.data.last_view_video.video.published_at 视频上架时间
     */
    public function courses(Request $request, UserServiceInterface $userService, CourseServiceInterface $courseService)
    {
        $page = (int)$request->input('page', 1);
        $pageSize = (int)$request->input('size', 10);

        ['data' => $data, 'total' => $total] = $userService->getUserCoursePaginateWithProgress(
            $this->id(),
            $page,
            $pageSize
        );

        if ($data) {
            $courseIds = array_column($data, 'course_id');

            // 关联的课程信息
            $courses = $courseService->chunk($courseIds, ['id', 'title', 'thumb', 'charge'], [], [], ['videos']);
            $courses = array_column($courses, null, 'id');

            // 关联课程视频信息
            $videoIds = [];
            foreach ($data as $tmpItem) {
                $videoIds[] = $tmpItem['last_view_video']['video_id'] ?? 0;
            }
            $videoIds = array_unique($videoIds);
            $videos = [];
            if ($videoIds) {
                $videos = $courseService->videoChunk($videoIds, ['id', 'title', 'duration', 'published_at'], [], [], []);
                $videos = array_column($videos, null, 'id');
            }

            foreach ($data as $key => $item) {
                $data[$key]['course'] = $courses[$item['course_id']] ?? [];
                if ($item['last_view_video']) {
                    $item['last_view_video'] = array_merge(
                        $item['last_view_video'],
                        ['video' => $videos[$item['last_view_video']['video_id']] ?? []],
                    );
                }
            }
        }

        return $this->data([
            'data' => $data,
            'total' => $total,
        ]);
    }

    /**
     * @api {get} /api/v3/member/courses/learned [V3]学员-录播课-已学-列表
     * @apiGroup 学员
     * @apiName MemberCoursesLearnedV3
     * @apiHeader Authorization Bearer+空格+token
     *
     * @apiParam {Number} page 页码
     * @apiParam {Number} size 每页数量
     *
     * @apiSuccess {Number} code 0成功,非0失败
     * @apiSuccess {Object} data 数据
     * @apiSuccess {Number} data.total 总数
     * @apiSuccess {Object[]} data.data
     * @apiSuccess {Number} data.data.learned_count 已学习课时
     * @apiSuccess {Object} data.data 观看进度记录
     * @apiSuccess {Number} data.data.id 记录ID
     * @apiSuccess {Number} data.data.is_watched 是否看完[1:是,0:否]
     * @apiSuccess {String} data.data.watched_at 看完时间
     * @apiSuccess {Number} data.data.progress 进度[0-100]
     * @apiSuccess {String} data.data.created_at 观看开始时间
     * @apiSuccess {String} data.data.updated_at 最近观看时间
     * @apiSuccess {Number} data.data.is_subscribe 是否购买课程[1:是,0:否]
     * @apiSuccess {Object} data.data.course 课程
     * @apiSuccess {String} data.data.course.title 课程名
     * @apiSuccess {String} data.data.course.thumb 课程封面
     * @apiSuccess {Number} data.data.course.videos_count 总课时
     * @apiSuccess {Number} data.data.course.charge 价格
     * @apiSuccess {Object} data.data.last_view_video 最近观看的视频记录
     * @apiSuccess {Number} data.data.last_view_video.id 记录id
     * @apiSuccess {Number} data.data.last_view_video.video_id videoId
     * @apiSuccess {Number} data.data.last_view_video.watch_seconds 已观看秒数
     * @apiSuccess {String} data.data.last_view_video.created_at 观看开始时间
     * @apiSuccess {String} data.data.last_view_video.updated_at 最近一次观看时间
     * @apiSuccess {String} data.data.last_view_video.watched_at 看完时间
     * @apiSuccess {Object} data.data.last_view_video.video
     * @apiSuccess {Number} data.data.last_view_video.video.id videoId
     * @apiSuccess {String} data.data.last_view_video.video.title 视频名
     * @apiSuccess {Number} data.data.last_view_video.video.duration 视频时长[s]
     * @apiSuccess {String} data.data.last_view_video.video.published_at 视频上架时间
     */
    public function learnedCourses(Request $request, UserServiceInterface $userService, CourseServiceInterface $courseService)
    {
        $page = (int)$request->input('page', 1);
        $pageSize = (int)$request->input('size', 10);

        ['data' => $data, 'total' => $total] = $userService->getUserLearnedCoursePaginateWithProgress(
            $this->id(),
            $page,
            $pageSize
        );

        if ($data) {
            $courseIds = array_column($data, 'course_id');

            // 读取关联的课程信息
            $courses = $courseService->chunk($courseIds, ['id', 'title', 'thumb', 'charge'], [], [], ['videos']);
            $courses = array_column($courses, null, 'id');

            // 关联课程视频信息
            $videoIds = [];
            foreach ($data as $tmpItem) {
                $videoIds[] = $tmpItem['last_view_video']['video_id'] ?? 0;
            }
            $videoIds = array_unique($videoIds);
            $videos = [];
            if ($videoIds) {
                $videos = $courseService->videoChunk($videoIds, ['id', 'title', 'duration', 'published_at'], [], [], []);
                $videos = array_column($videos, null, 'id');
            }

            foreach ($data as $key => $item) {
                $data[$key]['course'] = $courses[$item['course_id']] ?? [];
                if ($item['last_view_video']) {
                    $item['last_view_video'] = array_merge(
                        $item['last_view_video'],
                        ['video' => $videos[$item['last_view_video']['video_id']] ?? []],
                    );
                }
            }
        }

        return $this->data([
            'data' => $data,
            'total' => $total,
        ]);
    }

    /**
     * @api {get} /api/v3/member/courses/like [V3]学员-录播课-收藏-列表
     * @apiGroup 学员
     * @apiName  MemberCoursesLike
     * @apiHeader Authorization Bearer+空格+token
     *
     * @apiParam {Number} page 页码
     * @apiParam {Number} size 每页数量
     *
     * @apiSuccess {Number} code 0成功,非0失败
     * @apiSuccess {Object} data 数据
     * @apiSuccess {Number} data.total 总数
     * @apiSuccess {Object[]} data.data
     * @apiSuccess {Number} data.data.course_id 课程ID
     * @apiSuccess {Number} data.data.user_id 用户ID
     * @apiSuccess {String} data.data.created_at 收藏时间
     * @apiSuccess {Number} data.data.learned_count 已学习课时
     * @apiSuccess {Object} data.data.watch_record 观看进度记录
     * @apiSuccess {Number} data.data.watch_record.id 记录ID
     * @apiSuccess {Number} data.data.watch_record.is_watched 是否看完[1:是,0:否]
     * @apiSuccess {String} data.data.watch_record.watched_at 看完时间
     * @apiSuccess {Number} data.data.watch_record.progress 进度[0-100]
     * @apiSuccess {String} data.data.watch_record.created_at 观看开始时间
     * @apiSuccess {String} data.data.watch_record.updated_at 最近观看时间
     * @apiSuccess {Object} data.data.course 课程
     * @apiSuccess {String} data.data.course.title 课程名
     * @apiSuccess {String} data.data.course.thumb 课程封面
     * @apiSuccess {Number} data.data.course.videos_count 总课时
     * @apiSuccess {Number} data.data.course.charge 价格
     * @apiSuccess {Object} data.data.last_view_video 最近观看的视频记录
     * @apiSuccess {Number} data.data.last_view_video.id 记录id
     * @apiSuccess {Number} data.data.last_view_video.video_id videoId
     * @apiSuccess {Number} data.data.last_view_video.watch_seconds 已观看秒数
     * @apiSuccess {String} data.data.last_view_video.created_at 观看开始时间
     * @apiSuccess {String} data.data.last_view_video.updated_at 最近一次观看时间
     * @apiSuccess {String} data.data.last_view_video.watched_at 看完时间
     * @apiSuccess {Object} data.data.last_view_video.video
     * @apiSuccess {Number} data.data.last_view_video.video.id videoId
     * @apiSuccess {String} data.data.last_view_video.video.title 视频名
     * @apiSuccess {Number} data.data.last_view_video.video.duration 视频时长[s]
     * @apiSuccess {String} data.data.last_view_video.video.published_at 视频上架时间
     */
    public function likeCourses(Request $request, UserServiceInterface $userService, CourseServiceInterface $courseService)
    {
        $page = (int)$request->input('page', 1);
        $pageSize = (int)$request->input('size', 10);

        ['data' => $data, 'total' => $total] = $userService->getUserLikeCoursePaginateWithProgress($this->id(), $page, $pageSize);

        if ($data) {
            $courseIds = array_column($data, 'course_id');

            $courses = $courseService->chunk($courseIds, ['id', 'title', 'thumb', 'charge'], [], [], ['videos']);
            $courses = array_column($courses, null, 'id');

            // 关联课程视频信息
            $videoIds = [];
            foreach ($data as $tmpItem) {
                $videoIds[] = $tmpItem['last_view_video']['video_id'] ?? 0;
            }
            $videoIds = array_unique($videoIds);
            $videos = [];
            if ($videoIds) {
                $videos = $courseService->videoChunk($videoIds, ['id', 'title', 'duration', 'published_at'], [], [], []);
                $videos = array_column($videos, null, 'id');
            }

            foreach ($data as $key => $item) {
                $data[$key]['course'] = $courses[$item['course_id']] ?? [];
                if ($item['last_view_video']) {
                    $item['last_view_video'] = array_merge(
                        $item['last_view_video'],
                        ['video' => $videos[$item['last_view_video']['video_id']] ?? []],
                    );
                }
            }
        }

        return $this->data([
            'data' => $data,
            'total' => $total,
        ]);
    }

    /**
     * @api {POST} /api/v3/member/destroy [V3]学员-账号注销
     * @apiGroup 学员
     * @apiName  MemberDestroy
     * @apiHeader Authorization Bearer+空格+token
     * @apiDescription v4.8新增
     *
     * @apiSuccess {Number} code 0成功,非0失败
     * @apiSuccess {Object} data 数据
     */
    public function destroy(UserServiceInterface $userService)
    {
        try {
            $userService->storeUserDelete($this->id());
            return $this->success();
        } catch (ServiceException $e) {
            return $this->error($e->getMessage());
        }
    }

    /**
     * @api {POST} /api/v3/member/socialite/bindWithCode [V3]第三方账号-code绑定
     * @apiGroup 用户认证
     * @apiName  MemberSocialiteBindWithCode
     * @apiHeader Authorization Bearer+空格+token
     * @apiDescription v4.8新增
     *
     * @apiParam {String} string code
     *
     * @apiSuccess {Number} code 0成功,非0失败
     * @apiSuccess {Object} data 数据
     */
    public function socialiteBindByCode(Request $request, UserServiceInterface $userService)
    {
        $code = $request->input('code');
        if (!$code) {
            return $this->error(__('参数错误'));
        }

        try {
            $cacheKey = get_cache_key(CacheConstant::USER_SOCIALITE_LOGIN['name'], $code);
            $value = Cache::get($cacheKey);
            if (!$value) {
                throw new ServiceException(__('已过期'));
            }

            $value = unserialize($value);
            $type = $value['type'] ?? null;
            $app = $value['app'] ?? null;
            $data = $value['data'] ?? [];
            if ($type !== 'socialite' || !$app || !isset($data['openid'])) {
                throw new ServiceException(__('参数错误'));
            }

            $userService->socialiteBind($this->id(), $app, $data['openid'], $data, $data['unionid'] ?? '');

            Cache::forget($cacheKey);

            return $this->success();
        } catch (ServiceException $e) {
            return $this->error($e->getMessage());
        }
    }

    /**
     * @api {POST} /api/v3/member/tencent/faceVerify [V3]学员-实人认证
     * @apiGroup 用户认证
     * @apiName  MemberTencentFaceVerify
     * @apiHeader Authorization Bearer+空格+token
     * @apiDescription v4.9新增
     *
     * @apiParam {String} s_url 成功之后的跳转地址
     *
     * @apiSuccess {Number} code 0成功,非0失败
     * @apiSuccess {Object} data 数据
     * @apiSuccess {String} data.biz_token bizToken
     * @apiSuccess {String} data.rule_id RuleID
     * @apiSuccess {String} data.url 认证的URL
     * @apiSuccess {String} data.request_id RequestId
     */
    public function tencentFaceVerify(Request $request, MemberBus $bus, Face $face, UserServiceInterface $userService)
    {
        $sUrl = $request->input('s_url');
        if (!$sUrl) {
            return $this->error(__('参数错误'));
        }

        if ($sUrl === 'PC') {//PC使用默认的成功页面
            $sUrl = route('face.verify.success');
        }

        $userId = $this->id();
        if ($bus->isVerify($userId)) {
            return $this->error(__('当前学员已完成实人认证'));
        }

        $data = $face->create($sUrl);
        if (!$data) {
            return $this->error(__('无法发起实名认证'));
        }

        // 保存发起实名认证记录
        $userService->storeUserFaceVerifyTencentRecord(
            $this->id(),
            $data['rule_id'],
            $data['request_id'],
            $data['url'],
            $data['biz_token']
        );

        return $this->data($data);
    }

    /**
     * @api {GET} /api/v3/member/tencent/faceVerify [V3]学员-实人认证-结果查询
     * @apiGroup 用户认证
     * @apiName  MemberTencentFaceVerifyQuery
     * @apiHeader Authorization Bearer+空格+token
     * @apiDescription v4.9新增
     *
     * @apiParam {String} biz_token bizToken
     *
     * @apiSuccess {Number} code 0成功,非0失败
     * @apiSuccess {Object} data 数据
     */
    public function queryTencentFaceVerify(Request $request, Face $face, UserServiceInterface $userService, UploadBus $uploadBus)
    {
        $bizToken = $request->input('biz_token');
        $ruleId = $request->input('rule_id');
        if (!$bizToken || !$ruleId) {
            return $this->error(__('参数错误'));
        }
        $data = $face->query($ruleId, $bizToken);
        if (!$data) {
            return $this->success(['status' => BusConstant::USER_VERIFY_FACE_TENCENT_STATUS_FAIL]);
        }

        $verifyImageUrl = '';
        $verifyVideoUrl = '';

        $user = $this->user();

        if ($data['best_frame']) {
            ['media_image_id' => $mediaImageId] = $uploadBus->uploadBase64Content2Private(
                $user['nick_name'],
                sprintf('u-%d', $user['id']),
                $data['best_frame'],
                'user-verify/',
                sprintf('user-%d.png', $user['id']),
                'verify'
            );
            $verifyImageUrl = sprintf('id:%d', $mediaImageId);
        }
        if ($data['video_data']) {
            ['media_image_id' => $mediaImageId] = $uploadBus->uploadBase64Content2Private(
                $user['nick_name'],
                sprintf('u-%d', $user['id']),
                $data['video_data'],
                'user-verify/',
                sprintf('user-%d.mp4', $user['id']),
                'verify'
            );
            $verifyVideoUrl = sprintf('id:%d', $mediaImageId);
        }

        $userService->updateUserFaceVerifyTencentRecord(
            $this->id(),
            $bizToken,
            BusConstant::USER_VERIFY_FACE_TENCENT_STATUS_SUCCESS,
            $verifyImageUrl,
            $verifyVideoUrl
        );

        event(
            new UserVerifyFaceSuccessEvent(
                $this->id(),
                $data['info']['name'],
                $data['info']['id_number'],
                $verifyImageUrl,
                $verifyVideoUrl,
                Carbon::now()->toDateTimeLocalString()
            )
        );

        return $this->data([
            'status' => BusConstant::USER_VERIFY_FACE_TENCENT_STATUS_SUCCESS,
        ]);
    }

    /**
     * @api {GET} /api/v3/member/tencent/faceVerify [V3]学员-课程-学习明细
     * @apiGroup 学员
     * @apiName  MemberLearnedCourseDetail
     * @apiHeader Authorization Bearer+空格+token
     *
     * @apiSuccess {Number} code 0成功,非0失败
     * @apiSuccess {Object[]} data 数据
     * @apiSuccess {Number} data.id 课时ID
     * @apiSuccess {String} data.title 课时标题
     * @apiSuccess {String} data.published_at 课时发布时间
     * @apiSuccess {Number} data.duration 课时总时长,单位:秒
     * @apiSuccess {Number} data.watch_seconds 已学习时长
     * @apiSuccess {String} data.watched_at 课时看完结束时间
     * @apiSuccess {String} data.created_at 课时开始学习时间
     */
    public function learnedCourseDetail(
        Request                $request,
        UserServiceInterface   $userService,
        CourseServiceInterface $courseService,
        $courseId
    ) {
        $videos = $courseService->getCoursePublishedVideos($courseId, ['id', 'title', 'published_at', 'duration']);
        $videos = collect($videos)->sort(function ($a, $b) {
            return Carbon::parse($a['published_at'])->gte($b['published_at']);
        })->toArray();

        // 读取课时学习记录
        $watchRecords = $userService->getUserVideoWatchRecordsByChunkVideoIds($this->id(), array_column($videos, 'id'));
        $watchRecords = array_column($watchRecords, null, 'video_id');

        foreach ($videos as $key => $tmpVideoItem) {
            $tmpWatchRecord = $watchRecords[$tmpVideoItem['id']] ?? [];
            $tmpRecord = null;
            if ($tmpWatchRecord) {
                $tmpRecord = [
                    'watch_seconds' => $tmpWatchRecord['watch_seconds'],//已观看秒数
                    'watched_at' => $tmpWatchRecord['watched_at'] ? Carbon::parse($tmpWatchRecord['watched_at'])->toDateTimeLocalString() : null,
                    'created_at' => Carbon::parse($tmpWatchRecord['created_at'])->toDateTimeLocalString(),
                ];
            }

            $videos[$key]['watch_record'] = $tmpRecord;
        }

        return $this->data($videos);
    }
}
