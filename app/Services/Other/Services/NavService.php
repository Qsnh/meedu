<?php

/*
 * This file is part of the Qsnh/meedu.
 *
 * (c) 杭州白书科技有限公司
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
        $navs = Nav::query()
            ->with(['children'])
            ->select(['id', 'sort', 'name', 'url', 'active_routes', 'platform', 'parent_id', 'blank'])
            ->when($platform, function ($query) use ($platform) {
                $query->where('platform', $platform);
            })
            ->where('parent_id', 0)
            ->orderBy('sort')
            ->get()
            ->toArray();

        foreach ($navs as $key => $navItem) {
            $children = $navItem['children'] ?? [];
            if (!$children) {
                continue;
            }
            usort($children, function ($a, $b) {
                return $a['sort'] - $b['sort'];
            });
            $navs[$key]['children'] = $children;
        }

        return $navs;
    }
}
