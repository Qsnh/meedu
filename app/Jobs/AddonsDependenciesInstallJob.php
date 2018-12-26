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
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Symfony\Component\Process\Process;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Symfony\Component\Process\Exception\ProcessFailedException;

class AddonsDependenciesInstallJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $addons;
    public $type;

    /**
     * Create a new job instance.
     */
    public function __construct(Addons $addons, $type)
    {
        $this->addons = $addons;
        $this->type = $type;
    }

    /**
     * Execute the job.
     */
    public function handle()
    {
        // 解析composer.json文件
        $composerFile = $this->addons->path.DIRECTORY_SEPARATOR.'composer.json';
        if (! file_exists($composerFile)) {
            return;
        }

        $composer = json_decode(file_get_contents($composerFile), true);
        if (! isset($composer['require']) || count($composer['require']) == 0) {
            // 无依赖
            return;
        }

        $dependencies = $composer['require'];
        $logs = [];

        try {
            foreach ($dependencies as $dependency => $version) {
                if (! preg_match('/\//', $dependency)) {
                    // 不是包依赖
                    continue;
                }

                // 执行composer安装命令
                $process = new Process(['composer', 'required', "{$dependencies}={$version}"]);
                $process->run();

                if (! $process->isSuccessful()) {
                    // 执行失败
                    throw new ProcessFailedException($process);
                }

                // 记录日志
                $logs[] = $process->getOutput();
            }
        } catch (\Exception $exception) {
            exception_record($exception);
            $logs[] = $exception->getMessage();
        }

        // 记录日志
        $this->addons->logs()->save(new AddonsLog([
            'version' => $this->addons->currentVersion ? $this->addons->currentVersion->version : '',
            'type' => $this->type ?? '',
            'log' => json_encode($logs),
        ]));
    }
}
