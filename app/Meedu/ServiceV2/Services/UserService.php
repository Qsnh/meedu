<?php

/*
 * This file is part of the Qsnh/meedu.
 *
 * (c) 杭州白书科技有限公司
 */

namespace App\Meedu\ServiceV2\Services;

use App\Events\UserDeletedEvent;
use App\Exceptions\ServiceException;
use App\Events\UserDeleteCancelEvent;
use App\Events\UserDeleteSubmitEvent;
use App\Meedu\ServiceV2\Dao\UserDaoInterface;

class UserService implements UserServiceInterface
{
    protected $userDao;

    public function __construct(UserDaoInterface $userDao)
    {
        $this->userDao = $userDao;
    }

    public function getUserCoursePaginateWithProgress(int $userId, int $page, int $size): array
    {
        // 购买数据
        ['total' => $total, 'data' => $data] = $this->userDao->getUserCoursePaginate($userId, $page, $size);

        if ($data) {
            $courseIds = array_column($data, 'course_id');

            // 关联课程的观看进度记录[记录中含有:观看进度,开始时间,看完时间]
            $watchRecords = $this->userDao->getUserCourseWatchRecordsChunk($userId, $courseIds);
            $watchRecords && $watchRecords = array_column($watchRecords, null, 'course_id');

            // 关联已看课时数量
            $learnedCount = $this->userDao->getPerUserLearnedCourseVideoCount($userId, $courseIds);
            $learnedCount && $learnedCount = array_column($learnedCount, null, 'course_id');

            // 关联课程的最近一个视频观看记录
            $learnedVideoRecords = $this->userDao->getPerUserLearnedCourseLastVideo($userId, $courseIds);
            $learnedVideoRecords && $learnedVideoRecords = array_column($learnedVideoRecords, null, 'course_id');

            foreach ($data as $key => $item) {
                $tmpLearnedCount = $learnedCount[$item['course_id']] ?? [];
                // 已学课时
                $data[$key]['learned_count'] = $tmpLearnedCount['learned_count'] ?? 0;
                // 课程观看进度记录
                $data[$key]['watch_record'] = $watchRecords[$item['course_id']] ?? [];
                // 最后一次观看的视频
                $data[$key]['last_view_video'] = $learnedVideoRecords[$item['course_id']] ?? [];
            }
        }

        return compact('total', 'data');
    }

    public function getUserLearnedCoursePaginateWithProgress(int $userId, int $page, int $size): array
    {
        // 学习记录[免费课程+已购收费课程]
        ['total' => $total, 'data' => $data] = $this->userDao->getUserLearnedCoursePaginate($userId, $page, $size);

        if ($data) {
            $courseIds = array_column($data, 'course_id');

            // 关联已看课时
            $learnedCount = $this->userDao->getPerUserLearnedCourseVideoCount($userId, $courseIds);
            $learnedCount && $learnedCount = array_column($learnedCount, null, 'course_id');

            // 关联课程的最近一个视频观看记录
            $learnedVideoRecords = $this->userDao->getPerUserLearnedCourseLastVideo($userId, $courseIds);
            $learnedVideoRecords && $learnedVideoRecords = array_column($learnedVideoRecords, null, 'course_id');

            // 是否订阅
            $userCourse = $this->userDao->getUserCourses($userId, $courseIds);
            $userCourse && $userCourse = array_column($userCourse, null, 'course_id');

            foreach ($data as $key => $item) {
                $tmpLearnedCount = $learnedCount[$item['course_id']] ?? [];
                // 已学课时
                $data[$key]['learned_count'] = $tmpLearnedCount['learned_count'] ?? 0;
                // 是否订阅
                $data[$key]['is_subscribe'] = isset($userCourse[$item['course_id']]) ? 1 : 0;
                // 最后一次观看视频记录
                $data[$key]['last_view_video'] = $learnedVideoRecords[$item['course_id']] ?? [];
            }
        }

        return compact('total', 'data');
    }

    public function getUserLikeCoursePaginateWithProgress(int $userId, int $page, int $size): array
    {
        // 购买数据
        ['total' => $total, 'data' => $data] = $this->userDao->getUserLikeCoursePaginate($userId, $page, $size);

        if ($data) {
            $courseIds = array_column($data, 'course_id');

            // 关联观看记录[记录中含有:观看进度,开始时间,看完时间]
            $watchRecords = $this->userDao->getUserCourseWatchRecordsChunk($userId, $courseIds);
            $watchRecords && $watchRecords = array_column($watchRecords, null, 'course_id');

            // 关联已看课时
            $learnedCount = $this->userDao->getPerUserLearnedCourseVideoCount($userId, $courseIds);
            $learnedCount && $learnedCount = array_column($learnedCount, null, 'course_id');

            // 关联课程的最近一个视频观看记录
            $learnedVideoRecords = $this->userDao->getPerUserLearnedCourseLastVideo($userId, $courseIds);
            $learnedVideoRecords && $learnedVideoRecords = array_column($learnedVideoRecords, null, 'course_id');

            foreach ($data as $key => $item) {
                $tmpLearnedCount = $learnedCount[$item['course_id']] ?? [];
                // 已学课时
                $data[$key]['learned_count'] = $tmpLearnedCount['learned_count'] ?? 0;
                // 课程观看进度记录
                $data[$key]['watch_record'] = $watchRecords[$item['course_id']] ?? [];
                // 最后一次观看视频记录
                $data[$key]['last_view_video'] = $learnedVideoRecords[$item['course_id']] ?? [];
            }
        }

        return compact('total', 'data');
    }

    public function storeUserDelete(int $userId): void
    {
        $deleteJob = $this->userDao->findUserDeleteJobUnHandle($userId);
        if ($deleteJob) {
            throw new ServiceException(__('用户已申请注销'));
        }
        $detail = $this->userDao->findUserOrFail($userId, ['id', 'mobile']);
        $this->userDao->storeUserDeleteJob($userId, $detail['mobile']);

        event(new UserDeleteSubmitEvent($userId, $detail['mobile']));
    }

    public function cancelUserDelete(int $userId): void
    {
        $deleteJob = $this->userDao->findUserDeleteJobUnHandle($userId);
        if (!$deleteJob) {
            throw new ServiceException(__('当前用户不存在注销申请'));
        }
        $this->userDao->deleteUserDeleteJobUnHandle($userId);

        event(new UserDeleteCancelEvent($deleteJob['user_id'], $deleteJob['submit_at'], $deleteJob['expired_at']));
    }

    public function notifySimpleMessage(int $userId, string $message): void
    {
        $this->userDao->notifySimpleMessage($userId, $message);
    }

    public function destroyUser(int $userId): void
    {
        $this->userDao->deleteUserRelateData($userId);
        $this->userDao->destroyUser($userId);

        event(new UserDeletedEvent($userId));
    }

    public function userDeleteBatchHandle(): void
    {
        // 读取到期等待处理的申请-每次处理50条
        $jobs = $this->userDao->getUserDeleteJobUnHandle(50);
        if (!$jobs) {
            return;
        }

        foreach ($jobs as $jobItem) {
            $this->destroyUser($jobItem['user_id']);
            $this->userDao->changeUserDeleteJobsHandled([$jobItem['id']]);
        }
    }

    public function findUserById(int $userId): array
    {
        return $this->userDao->findUser(['id' => $userId], ['*']);
    }

    public function findUserByMobile(string $mobile): array
    {
        return $this->userDao->findUser(['mobile' => $mobile], ['*']);
    }

    public function storeUserLoginRecord(int $userId, string $token, string $platform, string $ua, string $ip): void
    {
        $loginId = $this->userDao->storeUserLoginRecord($userId, $token, $platform, $ua, $ip);
        $this->userDao->updateUserLastLoginId($userId, $loginId);
    }

    public function findLastLoginJTI(int $userId): string
    {
        $user = $this->userDao->findUser(['id' => $userId], ['id', 'last_login_id']);
        if (!$user['last_login_id']) {
            return '';
        }
        $loginRecord = $this->userDao->findUserLoginRecordOrFail($user['last_login_id']);
        return $loginRecord['jti'];
    }

    public function jtiLogout(int $userId, string $jti): void
    {
        $this->userDao->logoutUserLoginRecord($userId, $jti);
    }
}
