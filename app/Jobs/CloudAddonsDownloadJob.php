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
use GuzzleHttp\Client;
use App\Models\AddonsVersion;
use Illuminate\Bus\Queueable;
use Illuminate\Support\Facades\Log;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class CloudAddonsDownloadJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $addons;
    public $version;
    public $downloadUrl;
    public $nextStep;

    /**
     * Create a new job instance.
     */
    public function __construct(Addons $addons, AddonsVersion $version, string $downloadUrl)
    {
        $this->addons = $addons;
        $this->version = $version;
        $this->downloadUrl = $downloadUrl;
    }

    /**
     * Execute the job.
     */
    public function handle()
    {
        $client = new Client(['verify' => false]);
        $savePath = storage_path('app/addons/'.str_random(32).'.zip');
        $response = $client->get($this->downloadUrl, ['save_to' => $savePath]);
        if ($response->getStatusCode() != 200) {
            Log::error('插件下载出错，错误信息：'.$response->getBody());

            // 插件下载失败
            $this->addons->status = Addons::STATUS_DOWNLOAD_FAIL;
            $this->addons->save();

            return;
        }
        // 到这里下载成功，接下来是插件的安装或者升级[提交给任务立即处理]
        $this->addons->status = Addons::STATUS_DOWNLOAD_SUCCESS;
        $this->addons->save();
        dispatch_now(new AddonsInstallJob($this->addons, $this->version, $savePath));
    }
}
