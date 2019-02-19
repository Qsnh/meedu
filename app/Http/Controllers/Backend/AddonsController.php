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
use App\Jobs\AddonsInstallJob;
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
     * @param $name
     * @param $version
     *
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function installLocal($name, $version)
    {
        if (Addons::whereName($name)->exists()) {
            flash('插件已安装');

            return redirect(route('backend.addons.index'));
        }
        $file = request()->get('file');
        $localFilePath = storage_path("app/addons/{$file}.zip");
        DB::beginTransaction();
        try {
            // 创建插件记录
            $addons = Addons::create([
                'name' => $name,
                'thumb' => '',
                'current_version_id' => 0,
                'prev_version_id' => 0,
                'author' => 'meedu',
                'path' => '',
                'real_path' => '',
                'status' => Addons::STATUS_INSTALLING,
            ]);
            // 创建版本记录
            $addonsVersion = $addons->versions()->create([
                'version' => $version,
                'path' => '',
            ]);
            // 提交给队列任务处理
            $this->dispatch(new AddonsInstallJob($addons, $addonsVersion, $localFilePath));
            flash('插件安装任务生成成功，已投递到后台处理，请耐心等待。', 'success');

            DB::commit();

            return redirect(route('backend.addons.index'));
        } catch (\Exception $exception) {
            DB::rollBack();
            flash('插件安装失败，具体信息请查看日志');
            exception_record($exception);

            return redirect(route('backend.addons.index'));
        }
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

            app()->make(\App\Meedu\Addons::class)->switchVersion($addons->name, $version->version);

            DB::commit();
            flash('回滚成功', 'success');

            return back();
        } catch (\Exception $exception) {
            DB::rollBack();
            exception_record($exception);
            flash('回滚出现错误，错误信息：'.$exception->getMessage());

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
        flash('依赖安装任务已创建，请耐心等待后台执行完成，执行结果稍后可以在安装日志查看', 'success');

        return back();
    }
}
