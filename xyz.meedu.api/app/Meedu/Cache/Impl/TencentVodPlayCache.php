<?php

/*
 * This file is part of the MeEdu.
 *
 * (c) 杭州白书科技有限公司
 */

namespace App\Meedu\Cache\Impl;

use App\Meedu\Tencent\Vod;
use Illuminate\Support\Facades\Cache;
use App\Meedu\ServiceV2\Services\ConfigServiceInterface;

class TencentVodPlayCache
{

    private $id;
    private $videoId;
    private $previewSeconds;

    public const CACHE_NAME_TPL = 'tencent:vod:play:%s:%d';
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

        $tencentVod = new Vod($configService->getTencentVodConfig());

        $key = $this->key();
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
    }

    public function key(): string
    {
        return sprintf(self::CACHE_NAME_TPL, $this->videoId, $this->id);
    }

}
