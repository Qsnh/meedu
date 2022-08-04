<?php

/*
 * This file is part of the Qsnh/meedu.
 *
 * (c) 杭州白书科技有限公司
 */

namespace App\Http\Controllers\Backend\Api\V1;

use Illuminate\Http\Request;
use App\Models\AdministratorLog;

class LogController extends BaseController
{
    public function admin(Request $request)
    {
        $adminId = (int)$request->input('admin_id');
        $module = $request->input('module');
        $opt = $request->input('opt');

        $logs = AdministratorLog::query()
            ->when($adminId, function ($query) use ($adminId) {
                $query->where('admin_id', $adminId);
            })
            ->when($module, function ($query) use ($module) {
                $query->where('module', $module);
            })
            ->when($opt, function ($query) use ($opt) {
                $query->where('opt', $opt);
            })
            ->orderByDesc('id')
            ->paginate($request->input('size', 10));

        return $this->successData([
            'total' => $logs->total(),
            'data' => $logs->items(),
        ]);
    }
}
