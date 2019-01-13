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
use App\Models\AddonsLog;
use App\Models\AddonsVersion;
use Illuminate\Bus\Queueable;
use Illuminate\Support\Facades\DB;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class AddonsInstallJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $addons;
    public $compressFile;

    /**
     * Create a new job instance.
     */
    public function __construct(Addons $addons, string $compressFile)
    {
        $this->addons = $addons;
        $this->compressFile = $compressFile;
    }

    /**
     * Execute the job.
     */
    public function handle()
    {
        DB::beginTransaction();
        try {
            $addonsLib = app()->make(\App\Meedu\Addons::class);

            // 本地处理
            [$extractPath, $linkPath] = $addonsLib->install(
                $this->compressFile,
                $this->addons->name,
                $this->addons->version
            );

            // 创建版本
            $version = $this->addons->versions()->save(new AddonsVersion([
                'version' => $this->addons->version,
                'path' => $extractPath,
            ]));

            // 解析meedu配置
            $meedu = $addonsLib->parseMeedu();

            // 更新
            $this->addons->fill([
                'name' => $this->addons->name,
                'thumb' => '',
                'prev_version_id' => 0,
                'current_version_id' => $version->id,
                'author' => '本地安装',
                'path' => $linkPath,
                'real_path' => $extractPath,
                'main_url' => $meedu['main_url'] ?? '',
            ])->save();

            // 解析是否需要安装依赖
            dispatch(new AddonsDependenciesInstallJob($this->addons, AddonsLog::TYPE_INSTALL));

            DB::commit();
        } catch (\Exception $exception) {
            DB::rollBack();
            exception_record($exception);
        }
    }
}
