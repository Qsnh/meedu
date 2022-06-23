<?php

/*
 * This file is part of the Qsnh/meedu.
 *
 * (c) 杭州白书科技有限公司
 */

namespace App\Http\Controllers\Api\V3;

use Illuminate\Http\Request;
use App\Http\Controllers\Api\V2\BaseController;
use App\Meedu\ServiceV2\Services\UserServiceInterface;
use App\Meedu\ServiceV2\Services\CourseServiceInterface;

class MemberController extends BaseController
{

    /**
     * @api {get} /api/v3/member/courses 已购录播课
     * @apiGroup 我的
     * @apiVersion v3.0.0
     * @apiHeader Authorization Bearer+空格+token
     *
     * @apiParam {Number} page page
     * @apiParam {Number} size size
     *
     * @apiSuccess {Number} code 0成功,非0失败
     * @apiSuccess {Object} data 数据
     * @apiSuccess {[]Object} data.data
     * @apiSuccess {Number} data.data.course_id 课程ID
     * @apiSuccess {Number} data.data.user_id 用户ID
     * @apiSuccess {Number} data.data.charge 购买价格
     * @apiSuccess {String} data.data.created_at 购买时间
     * @apiSuccess {Number} data.data.learned_count 已学习课时
     * @apiSuccess {String} data.data.last_watched_at 最后一次观看时间
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
     * @apiSuccess {Number} data.total 总数
     */
    public function courses(Request $request, UserServiceInterface $userService, CourseServiceInterface $courseService)
    {
        $page = (int)$request->input('page', 1);
        $pageSize = (int)$request->input('size', 10);

        ['data' => $data, 'total' => $total] = $userService->getUserCoursePaginateWithProgress($this->id(), $page, $pageSize);

        if ($data) {
            $courseIds = array_column($data, 'course_id');
            $courses = $courseService->chunk($courseIds, ['id', 'title', 'thumb', 'charge'], [], [], ['videos']);
            $courses = array_column($courses, null, 'id');
            foreach ($data as $key => $item) {
                $data[$key]['course'] = $courses[$item['course_id']] ?? [];
            }
        }

        return $this->data([
            'data' => $data,
            'total' => $total,
        ]);
    }

    /**
     * @api {get} /api/v3/member/courses/learned 已学习录播课
     * @apiGroup 我的
     * @apiVersion v3.0.0
     * @apiHeader Authorization Bearer+空格+token
     *
     * @apiParam {Number} page page
     * @apiParam {Number} size size
     *
     * @apiSuccess {Number} code 0成功,非0失败
     * @apiSuccess {Object} data 数据
     * @apiSuccess {[]Object} data.data
     * @apiSuccess {Number} data.data.learned_count 已学习课时
     * @apiSuccess {String} data.data.last_watched_at 最后一次观看时间
     * @apiSuccess {Object} data.data 观看进度记录
     * @apiSuccess {Number} data.data.id 记录ID
     * @apiSuccess {Number} data.data.is_watched 是否看完[1:是,0:否]
     * @apiSuccess {String} data.data.watched_at 看完时间
     * @apiSuccess {Number} data.data.progress 进度[0-100]
     * @apiSuccess {String} data.data.created_at 观看开始时间
     * @apiSuccess {String} data.data.updated_at 最近观看时间
     * @apiSuccess {Object} data.data.course 课程
     * @apiSuccess {String} data.data.course.title 课程名
     * @apiSuccess {String} data.data.course.thumb 课程封面
     * @apiSuccess {Number} data.data.course.videos_count 总课时
     * @apiSuccess {Number} data.data.course.charge 价格
     * @apiSuccess {Number} data.total 总数
     */
    public function learnedCourses(Request $request, UserServiceInterface $userService, CourseServiceInterface $courseService)
    {
        $page = (int)$request->input('page', 1);
        $pageSize = (int)$request->input('size', 10);

        ['data' => $data, 'total' => $total] = $userService->getUserLearnedCoursePaginateWithProgress($this->id(), $page, $pageSize);

        if ($data) {
            $courseIds = array_column($data, 'course_id');
            $courses = $courseService->chunk($courseIds, ['id', 'title', 'thumb', 'charge'], [], [], ['videos']);
            $courses = array_column($courses, null, 'id');
            foreach ($data as $key => $item) {
                $data[$key]['course'] = $courses[$item['course_id']] ?? [];
            }
        }

        return $this->data([
            'data' => $data,
            'total' => $total,
        ]);
    }
}
