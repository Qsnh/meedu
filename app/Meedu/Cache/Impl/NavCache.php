<?php

/*
 * This file is part of the MeEdu.
 *
 * (c) 杭州白书科技有限公司
 */

namespace App\Meedu\Cache\Impl;

use Illuminate\Support\Facades\Cache;
use App\Services\Other\Services\NavService;
use App\Services\Other\Interfaces\NavServiceInterface;

class NavCache
{

    public const KEY_NAME = 'navs';

    /**
     * @var NavService
     */
    private $navService;

    public function __construct(NavServiceInterface $navService)
    {
        $this->navService = $navService;
    }

    public function get(string $platform)
    {
        return Cache::get($this->key($platform), function () use ($platform) {
            return $this->navService->all($platform);
        });
    }

    public function destroy(string $platform): void
    {
        Cache::forget($this->key($platform));
    }

    private function key(string $platform): string
    {
        return self::KEY_NAME . '-' . $platform;
    }

}
