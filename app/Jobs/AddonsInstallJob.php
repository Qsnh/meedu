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
use App\Events\AddonsInstallFailEvent;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class AddonsInstallJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $addons;
    public $version;
    public $compressFile;

    /**
     * AddonsInstallJob constructor.
     *
     * @param Addons        $addons
     * @param AddonsVersion $version
     * @param string        $compressFile
     */
    public function __construct(Addons $addons, AddonsVersion $version, string $compressFile)
    {
        $this->addons = $addons;
        $this->version = $version;
        $this->compressFile = $compressFile;
    }

    /**
     * Execute the job.
     */
    public function handle()
    {
        DB::beginTransaction();
        try {
            /**
             * @var \App\Meedu\Addons
             */
            $addonsLib = app()->make(\App\Meedu\Addons::class);

            // 本地处理
            [$extractPath, $linkPath] = $addonsLib->install(
                $this->compressFile,
                $this->addons->sign,
                $this->version->version
            );

            // 更新版本
            $this->version->update([
                'path' => $extractPath,
            ]);

            // 解析meedu配置
            $meedu = $addonsLib->parseMeedu($extractPath);

            // 更新
            $this->addons->fill([
                'prev_version_id' => $this->addons->current_version_id,
                'current_version_id' => $this->version->id,
                'path' => $linkPath,
                'real_path' => $extractPath,
                'main_url' => $meedu['main_url'] ?? '',
                'status' => Addons::STATUS_SUCCESS,
            ])->save();

            DB::commit();
        } catch (\Exception $exception) {
            DB::rollBack();
            exception_record($exception);

            event(new AddonsInstallFailEvent($this->addons));
        }
    }
}
