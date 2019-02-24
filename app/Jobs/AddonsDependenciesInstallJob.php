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
use Symfony\Component\Process\PhpExecutableFinder;
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
        $dependencies = app()->make(\App\Meedu\Addons::class)->parseDependencies(
            $this->addons->sign,
            $this->addons->currentVersion->version
        );
        $logs = [];

        try {
            // 设置环境变量
            $_ENV['COMPOSER_HOME'] = base_path('composer');
            // 寻找PHP可执行路径
            $php = (new PhpExecutableFinder())->find();
            // composer.phar文件路径
            $composer = base_path('composer.phar');

            foreach ($dependencies as $dependency => $version) {
                if (! preg_match('/\//', $dependency)) {
                    // 不是包依赖
                    continue;
                }

                // 执行安装命令
                $process = new Process([$php, $composer, 'require', "{$dependency}={$version}"]);
                $process->setWorkingDirectory(base_path());
                // 超时10分钟
                $process->setTimeout(600);
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
            'version' => optional($this->addons->currentVersion)->version ?? '',
            'type' => $this->type ?? '',
            'log' => json_encode($logs),
        ]));
    }
}
