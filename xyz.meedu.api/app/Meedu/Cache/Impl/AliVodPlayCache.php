<?php

/*
 * This file is part of the MeEdu.
 *
 * (c) 杭州白书科技有限公司
 */

namespace App\Meedu\Cache\Impl;

use App\Meedu\Aliyun\Vod;
use Illuminate\Support\Facades\Log;
use App\Exceptions\ServiceException;
use Illuminate\Support\Facades\Cache;
use App\Meedu\ServiceV2\Services\ConfigServiceInterface;

class AliVodPlayCache
{

    private $id;
    private $videoId;
    private $previewSeconds;

    public const CACHE_NAME_TPL = 'ali:vod:play:%s:%d:%d';
    public const CACHE_EXPIRE = 10800;

    public function __construct(int $id, string $videoId, int $previewSeconds = 0)
    {
        $this->id = $id;
        $this->videoId = $videoId;
        $this->previewSeconds = $previewSeconds;
    }

    public function get()
    {
        /**
         * @var ConfigServiceInterface $configService
         */
        $configService = app()->make(ConfigServiceInterface::class);

        $aliVod = new Vod($configService->getAliyunVodConfig());

        $key = $this->key();

        try {
            // 首先从缓存中读取播放地址
            $value = Cache::get($key);

            if (!$value) {
                $value = $aliVod->getPlayInfo($this->videoId, $this->previewSeconds);

                if ($value) {
                    Cache::put($key, $value, self::CACHE_EXPIRE);
                }
            }

            return $value;
        } catch (ServiceException $e) {
            throw new $e;
        } catch (\Exception $e) {
            Log::error(
                __METHOD__ . '|获取阿里云视频播放地址失败.错误信息:' . $e->getMessage(),
                ['id' => $this->id, 'video_id' => $this->videoId, 'preview_seconds' => $this->previewSeconds]
            );
            throw new ServiceException(__('无法获取视频播放地址'));
        }
    }

    public function key(): string
    {
        return sprintf(self::CACHE_NAME_TPL, $this->videoId, $this->id, $this->previewSeconds);
    }

}
