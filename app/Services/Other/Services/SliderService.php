<?php

/*
 * This file is part of the MeEdu.
 *
 * (c) 杭州白书科技有限公司
 */

namespace App\Services\Other\Services;

use App\Services\Other\Models\Slider;
use App\Services\Other\Interfaces\SliderServiceInterface;

class SliderService implements SliderServiceInterface
{
    public function all($platform = ''): array
    {
        return Slider::query()
            ->when($platform, function ($query) use ($platform) {
                $query->where('platform', $platform);
            })
            ->orderBy('sort')
            ->get()
            ->toArray();
    }
}
