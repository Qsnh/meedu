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

use Exception;
use App\Models\Addons;
use App\Meedu\MeEduCloud;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

class AddonsCloudController extends Controller
{
    /**
     * 已购买的插件.
     *
     * @param MeEduCloud $cloud
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(MeEduCloud $cloud)
    {
        $addons = collect($cloud->addons());
        $addonsService = app()->make(\App\Meedu\Addons::class);
        $addons = $addons->map(function ($item) use ($addonsService) {
            $item['installed'] = $addonsService->isInstall($item['sign']);

            return $item;
        });

        return view('backend.addons.remote', compact('addons'));
    }

    public function install(MeEduCloud $cloud, string $sign, string $version)
    {
        if (Addons::whereName($sign)->exists()) {
            flash('插件已安装');

            return redirect(route('backend.addons.index'));
        }

        DB::beginTransaction();
        try {
            // 创建插件记录
            $addons = Addons::create([
                'name' => $sign,
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
            // 提交任务给队列

            DB::commit();
        } catch (Exception $exception) {
            DB::rollBack();
            exception_record($exception);
            flash('安装错误');

            return back();
        }
    }

    public function upgrade(MeEduCloud $cloud, string $sign, string $version)
    {
        if (! Addons::whereName($sign)->exists()) {
            flash('插件未安装');

            return redirect(route('backend.addons.index'));
        }
    }
}
