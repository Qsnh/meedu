<?php

/*
 * This file is part of the Qsnh/meedu.
 *
 * (c) XiaoTeng <616896861@qq.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
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
        $navs = Nav::query()
            ->with(['children'])
            ->where('parent_id', 0)
            ->orderByRaw('platform asc,sort desc')
            ->paginate($request->input('size', 10));

        return $this->successData($navs);
    }

    public function create()
    {
        $navs = Nav::query()->where('parent_id', 0)->get()->toArray();
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
