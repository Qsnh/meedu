<?php

/*
 * This file is part of the Qsnh/meedu.
 *
 * (c) XiaoTeng <616896861@qq.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace App\Jobs;

use App\Models\Addons;
use App\Models\AddonsVersion;
use Illuminate\Bus\Queueable;
use Illuminate\Support\Facades\DB;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class AddonsUpgradeJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $addons;
    public $version;
    public $downloadIUrl;

    /**
     * AddonsUpgradeJob constructor.
     *
     * @param Addons        $addons
     * @param AddonsVersion $version
     * @param string        $downloadIUrl
     */
    public function __construct(Addons $addons, AddonsVersion $version, string $downloadIUrl)
    {
        $this->addons = $addons;
        $this->version = $version;
        $this->downloadIUrl = $downloadIUrl;
    }

    /**
     * @throws \Throwable
     */
    public function handle()
    {
        // 首先，下载文件
        $savePath = storage_path('app/addons/'.str_random(32).'.zip');
        $downloadResult = download($savePath, $this->downloadIUrl);
        if ($downloadResult === false) {
            $this->version->delete();

            return;
        }

        DB::beginTransaction();
        try {
            $addonsLib = app()->make(\App\Meedu\Addons::class);

            // 本地处理
            [$extractPath, $linkPath] = $addonsLib->install(
                $savePath,
                $this->addons->sign,
                $this->version->version
            );

            // 更新版本信息
            $this->version->update([
                'path' => $extractPath,
            ]);

            // 解析meedu配置
            $meedu = $addonsLib->parseMeedu($extractPath);

            // 依赖安装
            $dep = $meedu['require'] ?? [];
            if ($dep) {
                $result = $addonsLib->depRequire($this->addons->sign, $dep);
                throw_if(! $result, new \Exception('插件依赖安装任务创建失败'));
            }

            // 更新
            $this->addons->fill([
                'prev_version_id' => $this->addons->current_version_id,
                'current_version_id' => $this->version->id,
                'path' => $linkPath,
                'real_path' => $extractPath,
                'main_url' => $meedu['main_url'] ?? '',
            ])->save();

            DB::commit();
        } catch (\Exception $exception) {
            DB::rollBack();
            exception_record($exception);

            // 安装失败，删除本次version
            $this->version->delete();
        }
    }
}
