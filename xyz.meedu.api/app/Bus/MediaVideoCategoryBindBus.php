<?php

/*
 * This file is part of the MeEdu.
 *
 * (c) 杭州白书科技有限公司
 */

namespace App\Bus;

use Illuminate\Support\Facades\Cache;

class MediaVideoCategoryBindBus
{

    public function setCache(string $videoId, int $categoryId): void
    {
        Cache::put($this->keyName($videoId), $categoryId, 86400);
    }

    public function pull(string $videoId): int
    {
        return (int)Cache::get($this->keyName($videoId));
    }

    public function remove(string $videoId): void
    {
        Cache::forget($this->keyName($videoId));
    }

    private function keyName(string $videoId): string
    {
        return sprintf('video-upload-category:%s', $videoId);
    }

}
