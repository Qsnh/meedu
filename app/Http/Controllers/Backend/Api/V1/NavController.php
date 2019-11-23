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

use App\Models\Nav;
use App\Http\Requests\Backend\NavRequest;

class NavController extends BaseController
{
    public function index()
    {
        $navs = Nav::orderByDesc('id')->paginate(12);

        return $this->successData($navs);
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

        return $this->success();
    }
}
