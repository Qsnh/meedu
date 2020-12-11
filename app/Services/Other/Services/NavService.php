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

use App\Services\Other\Models\Nav;
use App\Services\Other\Interfaces\NavServiceInterface;

class NavService implements NavServiceInterface
{
    /**
     * @param string $platform
     * @return array
     */
    public function all($platform = ''): array
    {
        return Nav::query()
            ->with(['children'])
            ->select(['id', 'sort', 'name', 'url', 'active_routes', 'platform', 'parent_id', 'blank'])
            ->when($platform, function ($query) use ($platform) {
                $query->where('platform', $platform);
            })
            ->where('parent_id', 0)
            ->orderBy('sort')
            ->get()
            ->toArray();
    }
}
