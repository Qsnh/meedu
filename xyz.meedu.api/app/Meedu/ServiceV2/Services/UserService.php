<?php

/*
 * This file is part of the MeEdu.
 *
 * (c) 杭州白书科技有限公司
 */

namespace App\Meedu\ServiceV2\Services;

use App\Events\UserDeletedEvent;
use App\Exceptions\ServiceException;
use App\Meedu\ServiceV2\Models\Role;
use App\Events\UserDeleteCancelEvent;
use App\Events\UserDeleteSubmitEvent;
use App\Meedu\ServiceV2\Models\UserProfile;
use App\Meedu\ServiceV2\Dao\UserDaoInterface;
use App\Meedu\ServiceV2\Models\UserFaceVerifyTencentRecord;

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

    public function socialiteBind(int $userId, string $app, string $appId, array $data, string $unionId = ''): void
    {
        // unionId的绑定判断
        // 确保每个app的unionId(不同app但是unionId相同)绑定的user_id是相同的
        if ($unionId) {
            $record = $this->userDao->findSocialiteRecordByUnionId($unionId);
            if ($record && $record['user_id'] !== $userId) {
                throw new ServiceException(__('同渠道账号已绑定其它用户'));
            }
        }

        // 判断用户是否重复绑定app渠道的账号 => 每个用户对于同一个渠道(app)只能绑定一个账户
        $userSocialites = $this->userDao->findUserSocialites($userId);
        $userSocialites && $userSocialites = array_column($userSocialites, null, 'app');
        if (isset($userSocialites[$app])) {
            throw new ServiceException(__('您已经绑定了该渠道的账号'));
        }

        // 判断当前的渠道账号是否被重复绑定了 => 同一个渠道(app)的账号只能被一个用户绑定
        $record = $this->userDao->findSocialiteRecord($app, $appId);
        if ($record) {
            throw new ServiceException(__('当前渠道账号已绑定了其它账号'));
        }

        $this->userDao->storeSocialiteRecord($userId, $app, $appId, $data, $unionId);
    }

    public function findUserProfile(int $userId): array
    {
        $profile = $this->userDao->findUserProfile($userId);
        if (!$profile) {
            $this->userDao->storeUserProfile($userId, [
                'real_name' => '',
                'gender' => '',
                'age' => 0,
                'birthday' => '',
                'profession' => '',
                'address' => '',
                'graduated_school' => '',
                'diploma' => '',
                'id_number' => '',
                'id_frontend_thumb' => '',
                'id_backend_thumb' => '',
                'id_hand_thumb' => '',
            ]);
            $profile = $this->userDao->findUserProfile($userId);
        }
        return $profile;
    }

    public function storeUserFaceVerifyTencentRecord(int $userId, string $ruleId, string $requestId, string $url, string $bizToken): int
    {
        $record = UserFaceVerifyTencentRecord::create([
            'user_id' => $userId,
            'rule_id' => $ruleId,
            'request_id' => $requestId,
            'url' => $url,
            'biz_token' => $bizToken,
        ]);
        return $record['id'];
    }

    public function updateUserFaceVerifyTencentRecord(int $userId, string $bizToken, int $status, string $verifyImageUrl, string $verifyVideoUrl): int
    {
        return UserFaceVerifyTencentRecord::query()
            ->where('biz_token', $bizToken)
            ->where('user_id', $userId)
            ->update([
                'status' => $status,
                'verify_image_url' => $verifyImageUrl,
                'verify_video_url' => $verifyVideoUrl,
            ]);
    }

    public function change2Verified(int $userId, string $name, string $idNumber, string $verifyImageUrl): int
    {
        return UserProfile::query()
            ->where('user_id', $userId)
            ->update([
                'real_name' => $name,
                'id_number' => $idNumber,
                'is_verify' => 1,
                'verify_image_url' => $verifyImageUrl,
            ]);
    }

    public function getUserVideoWatchRecordsByChunkVideoIds(int $userId, array $videoIds): array
    {
        return $this->userDao->getUserVideoWatchRecordsByVideoIds($userId, $videoIds);
    }

    public function findRoleOrFail(int $id): array
    {
        return Role::query()->where('id', $id)->firstOrFail()->toArray();
    }


}
