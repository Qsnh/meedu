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

use App\Services\Other\Models\Link;
use App\Services\Other\Interfaces\LinkServiceInterface;

class LinkService implements LinkServiceInterface
{
    public function all(): array
    {
        return Link::query()->orderBy('sort')->get()->toArray();
    }
}
