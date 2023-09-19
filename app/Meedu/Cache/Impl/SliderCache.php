<?php

/*
 * This file is part of the MeEdu.
 *
 * (c) 杭州白书科技有限公司
 */

namespace App\Meedu\Cache\Impl;

use Illuminate\Support\Facades\Cache;
use App\Services\Other\Interfaces\SliderServiceInterface;

class SliderCache
{

    public const KEY_NAME = 'sliders';

    private $sliderService;

    public function __construct(SliderServiceInterface $sliderService)
    {
        $this->sliderService = $sliderService;
    }

    public function get(string $platform)
    {
        return Cache::get($this->key($platform), function () use ($platform) {
            return $this->sliderService->all($platform);
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
