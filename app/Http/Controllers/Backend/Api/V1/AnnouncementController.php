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

use App\Services\Other\Models\Announcement;
use App\Http\Requests\Backend\AnnouncementRequest;

class AnnouncementController extends BaseController
{
    public function index()
    {
        $announcements = Announcement::orderByDesc('id')->paginate(request()->input('size', 12));

        return $this->successData($announcements);
    }

    public function store(AnnouncementRequest $request)
    {
        Announcement::create($request->filldata());

        return $this->success();
    }

    public function edit($id)
    {
        $info = Announcement::findOrFail($id);

        return $this->successData($info);
    }

    public function update(AnnouncementRequest $request, $id)
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
