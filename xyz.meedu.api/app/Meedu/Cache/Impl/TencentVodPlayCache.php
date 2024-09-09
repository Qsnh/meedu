<?php

/*
 * This file is part of the MeEdu.
 *
 * (c) 杭州白书科技有限公司
 */

namespace App\Meedu\Cache\Impl;

use App\Meedu\Tencent\Vod;
use Illuminate\Support\Facades\Log;
use App\Exceptions\ServiceException;
use Illuminate\Support\Facades\Cache;
use App\Meedu\ServiceV2\Services\ConfigServiceInterface;

class TencentVodPlayCache
{

    private $id;
    private $videoId;
    private $previewSeconds;

    public const CACHE_NAME_TPL = 'tencent:vod:play:%s:%d';
    public const CACHE_EXPIRE = 1800;

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

        $key = $this->key();

        $tencentVod = new Vod($configService->getTencentVodConfig());

        try {
            $value = Cache::get($key);

            if (!$value) {
                $value = $tencentVod->getPlayUrls($this->videoId);

                if ($value) {
                    Cache::put($key, $value, self::CACHE_EXPIRE);
                }
            }

            $data = [];
            if ($value) {
                foreach ($value as $tmpItem) {
                    $data[] = array_merge($tmpItem, [
                        'url' => $tencentVod->generateUrlWithSignature($tmpItem['url'], $this->previewSeconds),
                    ]);
                }
            }

            return $data;
        } catch (ServiceException $e) {
            throw new $e;
        } catch (\Exception $e) {
            Log::error(
                __METHOD__ . '|获取腾讯云视频播放地址失败.错误信息:' . $e->getMessage(),
                ['id' => $this->id, 'video_id' => $this->videoId, 'preview_seconds' => $this->previewSeconds]
            );
            throw new ServiceException(__('无法获取视频播放地址'));
        }
    }

    public function key(): string
    {
        return sprintf(self::CACHE_NAME_TPL, $this->videoId, $this->id);
    }

}
