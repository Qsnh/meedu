<?php

/*
 * This file is part of the Qsnh/meedu.
 *
 * (c) 杭州白书科技有限公司
 */

namespace App\Http\Controllers\Backend\Api\V1;

use Illuminate\Http\Request;
use App\Constant\FrontendConstant;
use App\Services\Other\Models\Nav;
use App\Http\Requests\Backend\NavRequest;

class NavController extends BaseController
{
    public function index(Request $request)
    {
        $platform = $request->input('platform');

        $navs = Nav::query()
            ->select([
                'id', 'sort', 'name', 'url', 'active_routes', 'platform', 'parent_id',
                'blank', 'created_at', 'updated_at',
            ])
            ->with(['children'])
            ->when($platform, function ($query) use ($platform) {
                $query->where('platform', $platform);
            })
            ->where('parent_id', 0)
            ->orderBy('sort')
            ->get();

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
        Nav::create($request->filldata());

        return $this->success();
    }

    public function edit($id)
    {
        $info = Nav::findOrFail($id);

        return $this->successData($info);
    }

    public function update(NavRequest $request, $id)
    {
        $role = Nav::findOrFail($id);
        $role->fill($request->filldata())->save();

        return $this->success();
    }

    public function destroy($id)
    {
        Nav::destroy($id);

        // 重置parent_id
        Nav::query()->where('parent_id', $id)->update(['parent_id' => 0]);

        return $this->success();
    }
}
