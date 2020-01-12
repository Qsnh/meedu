<?php

/*
 * This file is part of the Qsnh/meedu.
 *
 * (c) XiaoTeng <616896861@qq.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace App\Meedu;

use Illuminate\Support\Str;
use Illuminate\Filesystem\Filesystem;

class Addons
{
    /**
     * @var 插件存储路径
     */
    public $path;

    /**
     * @var Filesystem
     */
    public $file;

    public $providersMapFile;

    public function __construct()
    {
        $this->path = base_path('addons');
        $this->providersMapFile = base_path('addons/addons_service_provider.json');
        $this->file = app()->make(Filesystem::class);
    }

    /**
     * 获取全部插件.
     *
     * @throws \Illuminate\Contracts\Filesystem\FileNotFoundException
     */
    public function addons()
    {
        $dirs = $this->file->directories($this->path);
        $rows = [];
        foreach ($dirs as $dir) {
            $meeduConfigPath = $dir . DIRECTORY_SEPARATOR . 'meedu.json';
            if (!$this->file->exists($meeduConfigPath)) {
                continue;
            }
            $config = $this->file->get($dir . DIRECTORY_SEPARATOR . 'meedu.json');
            if (!$config) {
                continue;
            }
            $rows[$dir] = json_decode($config, true);
        }

        return $rows;
    }

    /**
     * 生成ServiceProviderMapping.
     * @param string $except
     * @throws \Illuminate\Contracts\Filesystem\FileNotFoundException
     */
    public function reGenProvidersMap($except = '')
    {
        $addons = $this->addons();
        if (!$addons) {
            return;
        }
        $providersBox = [];
        foreach ($addons as $dir => $addon) {
            $sign = pathinfo($dir, PATHINFO_FILENAME);
            $providers = $this->file->glob($dir . DIRECTORY_SEPARATOR . '*ServiceProvider.php');
            if (!$providers) {
                continue;
            }
            foreach ($providers as $provider) {
                $providerName = pathinfo($provider, PATHINFO_FILENAME);
                $namespace = "\\Addons\\{$sign}\\{$providerName}";
                if ($except && Str::contains($namespace, $except)) {
                    continue;
                }
                $providersBox[] = $namespace;
            }
        }
        if (!$providersBox) {
            return;
        }
        $this->file->put($this->providersMapFile, json_encode($providersBox));
    }

    /**
     * @return array|mixed
     *
     * @throws \Illuminate\Contracts\Filesystem\FileNotFoundException
     */
    public function getProvidersMap()
    {
        if (!$this->file->exists($this->providersMapFile)) {
            return [];
        }

        return json_decode($this->file->get($this->providersMapFile));
    }
}
