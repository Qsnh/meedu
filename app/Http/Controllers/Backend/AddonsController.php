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
use App\Models\AddonsVersion;
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

    public function remoteAddons()
    {
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

            return back();
        }
        $localFilePath = storage_path("app/addons/{$name}.zip");
        DB::beginTransaction();
        try {
            // 本地处理
            [$extractPath, $linkPath] = app()->make(\App\Meedu\Addons::class)->install($localFilePath, $name, $version);

            // 创建插件
            $addons = Addons::create([
                'name' => $name,
                'thumb' => '',
                'current_version_id' => 0,
                'prev_version_id' => 0,
                'author' => '本地安装',
                'path' => $linkPath,
                'real_path' => $extractPath,
            ]);

            // 创建版本
            $version = $addons->versions()->save(new AddonsVersion([
                'version' => $version,
                'path' => $extractPath,
            ]));

            $addons->current_version_id = $version->id;
            $addons->save();

            // 解析是否需要安装依赖
            $this->dispatch(new AddonsDependenciesInstallJob($addons, AddonsLog::TYPE_INSTALL));

            DB::commit();

            flash('安装成功', 'success');

            return redirect(route('backend.addons.index'));
        } catch (\Exception $exception) {
            DB::rollBack();
            exception_record($exception);
            flash('安装出现错误，错误信息：'.$exception->getMessage());

            return back();
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
        $this->dispatch(new AddonsDependenciesInstallJob($addons, AddonsLog::TYPE_INSTALL));
        flash('已提交，请耐心等待，执行结果稍后可以查看日志', 'success');

        return back();
    }
}
