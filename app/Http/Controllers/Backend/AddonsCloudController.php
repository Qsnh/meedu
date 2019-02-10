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
use App\Models\AddonsVersion;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Jobs\CloudAddonsDownloadJob;

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
        $installedAddons = Addons::whereIn('sign', $addons->pluck('sign')->toArray())->pluck('current_version_id', 'sign');
        $addons = $addons->map(function ($item) use ($installedAddons) {
            // 是否已安装
            $item['installed'] = isset($installedAddons[$item['sign']]);

            // 是否需要升级
            $item['upgrade'] = false;
            if ($item['installed']) {
                $version = AddonsVersion::whereId($installedAddons[$item['sign']])->first();
                $item['upgrade'] = version_compare($version->version, $item['version'], '<');
            }

            return $item;
        });

        return view('backend.addons.remote', compact('addons'));
    }

    /**
     * 安装.
     *
     * @param MeEduCloud $cloud
     * @param string     $sign
     * @param string     $version
     *
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
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
            // 获取插件下载地址
            $downloadUrl = $cloud->addonsDownloadUrl($sign);

            // 提交任务给队列
            $this->dispatch(new CloudAddonsDownloadJob($addons, $addonsVersion, $downloadUrl));

            DB::commit();

            flash('插件安装任务创建成功，已提交给后台系统处理，请稍候。', 'success');

            return redirect(route('backend.addons.remote.index'));
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
