<?php

/*
 * This file is part of the Qsnh/meedu.
 *
 * (c) 杭州白书科技有限公司
 */

namespace App\Bus;

use App\Constant\CacheConstant;
use App\Services\Base\Services\CacheService;
use App\Services\Member\Services\UserService;
use App\Services\Course\Services\VideoService;
use App\Services\Base\Interfaces\CacheServiceInterface;
use App\Services\Member\Interfaces\UserServiceInterface;
use App\Services\Course\Interfaces\VideoServiceInterface;

class VideoBus
{

    /**
     * @var VideoService
     */
    protected $videoService;

    public function __construct(VideoServiceInterface $videoService)
    {
        $this->videoService = $videoService;
    }

    /**
     * 用户视频观看时长记录
     * @param int $userId
     * @param int $videoId
     * @param int $duration
     * @throws \Illuminate\Contracts\Container\BindingResolutionException
     */
    public function userVideoWatchDurationRecord(int $userId, int $videoId, int $duration): void
    {
        // 查找观看的视频
        $video = $this->videoService->find($videoId);
        // 计算是否看完
        $isWatched = $video['duration'] <= $duration;

        /**
         * @var CacheService $cacheService
         */
        $cacheService = app()->make(CacheServiceInterface::class);
        $cacheKey = get_cache_key(CacheConstant::USER_VIDEO_WATCH_DURATION['name'], $video['id']);
        $lastSubmitTimestamp = (int)$cacheService->get($cacheKey);

        /**
         * @var UserService $userService
         */
        $userService = app()->make(UserServiceInterface::class);

        // 用户每天的观看时间统计
        if (($diffSeconds = $duration - $lastSubmitTimestamp) >= 0) {
            $userService->watchStatSave($userId, $diffSeconds);
        }

        // 用户视频观看进度
        $userService->recordUserVideoWatch($userId, $video['course_id'], $videoId, $duration, $isWatched);

        // 提交时间写入缓存
        $cacheService->put($cacheKey, $duration, CacheConstant::USER_VIDEO_WATCH_DURATION['expire']);
    }
}
