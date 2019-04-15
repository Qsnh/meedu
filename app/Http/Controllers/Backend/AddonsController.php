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
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

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
     * 插件卸载.
     *
     * @param int $addonsId
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function uninstall(int $addonsId)
    {
        $addons = Addons::whereId($addonsId)->firstOrFail();
        DB::beginTransaction();
        try {
            // 删除本地软链接
            app()->make(\App\Meedu\Addons::class)->uninstall($addons->sign, optional($addons->currentVersion)->version ?? '');

            // 删除插件版本
            $addons->versions()->delete();
            // 删除插件
            $addons->delete();

            DB::commit();

            flash('插件卸载成功', 'success');

            return back();
        } catch (\Exception $exception) {
            DB::rollBack();
            exception_record($exception);
            flash('插件卸载失败');

            return back();
        }
    }

    /**
     * 插件依赖安装回调.
     *
     * @param Request $request
     *
     * @return mixed
     */
    public function callback(Request $request)
    {
        $key = $request->input('key');
        $addonsSign = $request->input('addons', '');
        $status = $request->input('status', '');
        if ($key != config('meedu.addons.api_key')) {
            abort(401);
        }
        $addons = Addons::where('sign', $addonsSign)->firstOrFail();
        $addons->status == 'success' ? Addons::STATUS_SUCCESS : Addons::STATUS_DEP_INSTALL_FAIL;
        $addons->save();

        return $status;
    }
}
