<?php

/*
 * This file is part of the Qsnh/meedu.
 *
 * (c) XiaoTeng <616896861@qq.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace App\Services\Other\Services;

use App\Services\Other\Models\Slider;
use App\Services\Other\Interfaces\SliderServiceInterface;

class SliderService implements SliderServiceInterface
{
    public function all(): array
    {
        return Slider::orderBy('sort')->get()->toArray();
    }
}
