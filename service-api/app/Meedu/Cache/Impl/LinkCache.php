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

    private $linkService;

    public function __construct(LinkServiceInterface $linkService)
    {
        $this->linkService = $linkService;
    }

    public function get()
    {
        return Cache::get(self::KEY_NAME, function () {
            return $this->linkService->all();
        });
    }

    public function destroy()
    {
        Cache::forget(self::KEY_NAME);
    }

}
