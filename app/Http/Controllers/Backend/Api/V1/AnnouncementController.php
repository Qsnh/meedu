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

use App\Models\Announcement;
use App\Http\Requests\Backend\AnnoucementRequest;

class AnnouncementController extends BaseController
{
    public function index()
    {
        $links = Announcement::orderByDesc('id')->paginate(12);

        return $links;
    }

    public function store(AnnoucementRequest $request)
    {
        Announcement::create($request->filldata());

        return $this->success();
    }

    public function edit($id)
    {
        $info = Announcement::findOrFail($id);

        return $this->successData($info);
    }

    public function update(AnnoucementRequest $request, $id)
    {
        $role = Announcement::findOrFail($id);
        $role->fill($request->filldata())->save();

        return $this->success();
    }

    public function destroy($id)
    {
        Announcement::destroy($id);

        return $this->success();
    }
}
