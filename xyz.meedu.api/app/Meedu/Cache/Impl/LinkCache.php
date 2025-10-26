<?php

/*
 * This file is part of the MeEdu.
 *
 * (c) 杭州白书科技有限公司
 */

namespace App\Meedu\Cache\Impl;

use Illuminate\Support\Facades\Cache;
use App\Services\Other\Interfaces\LinkServiceInterface;

class LinkCache
{

    public const KEY_NAME = 'links';
    public const CACHE_EXPIRE = 1296000; // 15天

    private $linkService;

    public function __construct(LinkServiceInterface $linkService)
    {
        $this->linkService = $linkService;
    }

    public function get()
    {
        return Cache::remember(self::KEY_NAME, self::CACHE_EXPIRE, function () {
            return $this->linkService->all();
        });
    }

    public function destroy()
    {
        Cache::forget(self::KEY_NAME);
    }

}
