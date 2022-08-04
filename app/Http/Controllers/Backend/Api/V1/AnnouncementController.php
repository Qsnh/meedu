<?php

/*
 * This file is part of the Qsnh/meedu.
 *
 * (c) 杭州白书科技有限公司
 */

namespace App\Http\Controllers\Backend\Api\V1;

use Illuminate\Support\Arr;
use App\Models\AdministratorLog;
use App\Services\Other\Models\Announcement;
use App\Http\Requests\Backend\AnnouncementRequest;

class AnnouncementController extends BaseController
{
    public function index()
    {
        $announcements = Announcement::query()
            ->select([
                'id', 'admin_id', 'created_at', 'view_times', 'title',
            ])
            ->orderByDesc('id')
            ->paginate(request()->input('size', 10));

        AdministratorLog::storeLog(
            AdministratorLog::MODULE_ANNOUNCEMENT,
            AdministratorLog::OPT_VIEW,
            []
        );

        return $this->successData($announcements);
    }

    public function store(AnnouncementRequest $request)
    {
        $data = $request->filldata();

        Announcement::create($data);

        AdministratorLog::storeLog(
            AdministratorLog::MODULE_ANNOUNCEMENT,
            AdministratorLog::OPT_STORE,
            $data
        );

        return $this->success();
    }

    public function edit($id)
    {
        $announcement = Announcement::query()->where('id', $id)->firstOrFail();

        AdministratorLog::storeLog(
            AdministratorLog::MODULE_ANNOUNCEMENT,
            AdministratorLog::OPT_VIEW,
            compact('id')
        );

        return $this->successData($announcement);
    }

    public function update(AnnouncementRequest $request, $id)
    {
        $data = $request->filldata();

        $announcement = Announcement::query()->where('id', $id)->firstOrFail();

        AdministratorLog::storeLogDiff(
            AdministratorLog::MODULE_ANNOUNCEMENT,
            AdministratorLog::OPT_UPDATE,
            Arr::only($data, [
                'admin_id', 'announcement', 'created_at', 'view_times', 'title',
            ]),
            Arr::only($announcement->toArray(), [
                'admin_id', 'announcement', 'created_at', 'view_times', 'title',
            ])
        );

        $announcement->fill($data)->save();

        return $this->success();
    }

    public function destroy($id)
    {
        Announcement::destroy($id);

        AdministratorLog::storeLog(
            AdministratorLog::MODULE_ANNOUNCEMENT,
            AdministratorLog::OPT_DESTROY,
            compact('id')
        );

        return $this->success();
    }
}
