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
        $localFilePath = storage_path("app/addons/{$name}.zip");
        if (! app()->make('files')->exists($localFilePath)) {
            flash('文件不存在');

            return back();
        }
        if (Addons::whereName($name)->exists()) {
            flash('插件已安装');

            return back();
        }

        DB::beginTransaction();
        try {
            // 解压
            $extractPath = app_path("app/addons/{$name}/{$version}");
            if (! app()->make('files')->exists($extractPath)) {
                app()->make('files')->makeDirectory($extractPath, 0755, true);
            }
            // 解压文件
            \Chumper\Zipper\Facades\Zipper::make($localFilePath)->extractTo($extractPath);

            // 创建软连接
            $linkPath = base_path("addons/{$name}");
            if (app()->make('files')->exists($linkPath)) {
                app()->make('files')->deleteDirectory($linkPath);
            }
            app()->make('files')->link($extractPath, $linkPath);

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

    public function showLogs($addonsId)
    {
        $addons = Addons::findOrFail($addonsId);
        $logs = $addons->logs()->orderByDesc('created_at')->limit(20)->get();

        return view('backend.addons.logs', compact('addons', 'logs'));
    }

    public function showVersions($addonsId)
    {
        $addons = Addons::findOrFail($addonsId);
        $versions = $addons->versions()->orderByDesc('created_at')->get();

        return view('backend.addons.versions', compact('addons', 'versions'));
    }
}
