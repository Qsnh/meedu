<?php

/*
 * This file is part of the Qsnh/meedu.
 *
 * (c) XiaoTeng <616896861@qq.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace App\Http\Controllers\Backend;

use App\Models\Addons;
use App\Models\AddonsLog;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Jobs\AddonsDependenciesInstallJob;

class AddonsController extends Controller
{
    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        $addons = Addons::all();

        return view('backend.addons.index', compact('addons'));
    }

    /**
     * @param $addonsId
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function showLogs($addonsId)
    {
        $addons = Addons::findOrFail($addonsId);
        $logs = $addons->logs()->orderByDesc('created_at')->limit(20)->get();

        return view('backend.addons.logs', compact('addons', 'logs'));
    }

    /**
     * @param $addonsId
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function showVersions($addonsId)
    {
        $addons = Addons::findOrFail($addonsId);
        $versions = $addons->versions()->orderByDesc('created_at')->get();

        return view('backend.addons.versions', compact('addons', 'versions'));
    }

    /**
     * @param $addonsId
     * @param $versionId
     *
     * @return \Illuminate\Http\RedirectResponse
     *
     * @throws \Throwable
     */
    public function versionSwitch($addonsId, $versionId)
    {
        $addons = Addons::findOrFail($addonsId);
        if ($addons->current_version_id == $versionId) {
            flash('参数错误');

            return back();
        }
        $version = $addons->versions()->whereId($versionId)->firstOrFail();

        DB::beginTransaction();
        try {
            // 修改版本信息
            $addons->prev_version_id = $addons->current_version_id;
            $addons->current_version_id = $version->id;
            $addons->save();

            app()->make(\App\Meedu\Addons::class)->switchVersion($addons->sign, $version->version);

            DB::commit();
            flash('切换版本成功', 'success');

            return back();
        } catch (\Exception $exception) {
            DB::rollBack();
            exception_record($exception);
            flash('切换版本出现错误，错误信息：'.$exception->getMessage());

            return back();
        }
    }

    /**
     * @param $addonsId
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function submitDependenciesInstallTask($addonsId)
    {
        $addons = Addons::findOrFail($addonsId);
        $this->dispatch(new AddonsDependenciesInstallJob($addons, AddonsLog::TYPE_DEPENDENCY));
        flash('依赖安装任务已创建，执行结果稍后可以在安装日志查看', 'success');

        return back();
    }
}
