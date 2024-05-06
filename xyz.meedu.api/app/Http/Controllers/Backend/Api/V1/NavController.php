<?php

/*
 * This file is part of the MeEdu.
 *
 * (c) 杭州白书科技有限公司
 */

namespace App\Http\Controllers\Backend\Api\V1;

use Illuminate\Support\Arr;
use Illuminate\Http\Request;
use App\Events\NavUpdateEvent;
use App\Models\AdministratorLog;
use App\Constant\FrontendConstant;
use App\Services\Other\Models\Nav;
use App\Http\Requests\Backend\NavRequest;

class NavController extends BaseController
{
    public function index(Request $request)
    {
        $platform = $request->input('platform');

        $navs = Nav::query()
            ->with(['children'])
            ->select([
                'id', 'sort', 'name', 'url', 'active_routes', 'platform', 'parent_id',
                'blank', 'created_at', 'updated_at',
            ])
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

        AdministratorLog::storeLog(
            AdministratorLog::MODULE_NAV,
            AdministratorLog::OPT_VIEW,
            compact('platform')
        );

        return $this->successData($navs);
    }

    public function create()
    {
        $navs = Nav::query()->where('parent_id', 0)->where('platform', FrontendConstant::NAV_PLATFORM_PC)->get()->toArray();
        $platforms = [
            [
                'id' => FrontendConstant::NAV_PLATFORM_PC,
                'name' => FrontendConstant::NAV_PLATFORM_PC,
            ],
            [
                'id' => FrontendConstant::NAV_PLATFORM_H5,
                'name' => FrontendConstant::NAV_PLATFORM_H5,
            ]
        ];

        return $this->successData([
            'navs' => $navs,
            'platforms' => $platforms,
        ]);
    }

    public function store(NavRequest $request)
    {
        $data = $request->filldata();

        Nav::create($data);

        AdministratorLog::storeLog(
            AdministratorLog::MODULE_NAV,
            AdministratorLog::OPT_STORE,
            $data
        );

        event(new NavUpdateEvent());

        return $this->success();
    }

    public function edit($id)
    {
        $nav = Nav::query()->where('id', $id)->firstOrFail();

        AdministratorLog::storeLog(
            AdministratorLog::MODULE_NAV,
            AdministratorLog::OPT_VIEW,
            compact('id')
        );

        return $this->successData($nav);
    }

    public function update(NavRequest $request, $id)
    {
        $data = $request->filldata();

        $nav = Nav::query()->where('id', $id)->firstOrFail();

        AdministratorLog::storeLogDiff(
            AdministratorLog::MODULE_NAV,
            AdministratorLog::OPT_UPDATE,
            $data,
            Arr::only($nav->toArray(), [
                'sort', 'name', 'url', 'active_routes', 'platform', 'parent_id', 'blank',
            ])
        );

        $nav->fill($data)->save();

        event(new NavUpdateEvent());

        return $this->success();
    }

    public function destroy($id)
    {

        AdministratorLog::storeLog(
            AdministratorLog::MODULE_NAV,
            AdministratorLog::OPT_DESTROY,
            compact('id')
        );

        Nav::destroy($id);

        // 重置parent_id
        Nav::query()->where('parent_id', $id)->update(['parent_id' => 0]);

        event(new NavUpdateEvent());

        return $this->success();
    }
}
