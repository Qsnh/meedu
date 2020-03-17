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

use Illuminate\Http\Request;
use Illuminate\Filesystem\Filesystem;

class Setting
{
    const VERSION = 1;
    protected $files;
    protected $dist;

    public function __construct()
    {
        $this->files = new Filesystem();
        $this->dist = config('meedu.save');
    }

    /**
     * @param $param
     * @throws \Illuminate\Contracts\Filesystem\FileNotFoundException
     */
    public function save($param)
    {
        $data = $param;
        if ($data instanceof Request) {
            $data = $param->all();
        }
        $data['version'] = self::VERSION;
        $this->put($data);
    }

    /**
     * @param $params
     * @throws \Illuminate\Contracts\Filesystem\FileNotFoundException
     */
    public function append($params)
    {
        foreach ($params as $key => $item) {
            config([$key => $item]);
        }
        $this->put($this->getCanEditConfig());
    }

    /**
     * 自定义配置同步到Laravel系统中.
     */
    public function sync()
    {
        $saveConfig = $this->get();
        if (!isset($saveConfig['version'])) {
            // 老版本的配置保存方式
            collect($this->get())->map(function ($item, $key) {
                config([$key => $item]);
            });
        } else {
            // v1版本的配置保存方式
            if ((int)$saveConfig['version'] === self::VERSION) {
                $arr = array_compress($saveConfig);
                foreach ($arr as $key => $item) {
                    config([$key => $item]);
                }
            }
        }
        $this->specialSync();
    }

    /**
     * 一些特殊配置.
     */
    protected function specialSync(): void
    {
        // 短信服务注册
        config(['sms.default.gateways' => [config('meedu.system.sms')]]);
    }

    /**
     * 修改配置.
     *
     * @param array $setting
     *
     * @throws \Illuminate\Contracts\Filesystem\FileNotFoundException
     */
    public function put(array $setting): void
    {
        $this->files->put($this->dist, json_encode($setting));
    }

    /**
     * 读取自定义配置.
     *
     * @return array
     *
     * @throws \Illuminate\Contracts\Filesystem\FileNotFoundException
     */
    public function get(): array
    {
        if (!$this->files->exists($this->dist)) {
            return [];
        }
        $jsonContent = $this->files->get($this->dist);
        $arrayContent = json_decode($jsonContent, true);

        return $arrayContent;
    }

    /**
     * 获取可以编辑的配置
     * @return array
     */
    public function getCanEditConfig(): array
    {
        $meedu = config('meedu');
        $config = [
            'app' => config('app'),
            'meedu' => $meedu,
            'sms' => config('sms'),
            'services' => config('services'),
            'pay' => config('pay'),
            'tencent' => config('tencent'),
            'filesystems' => config('filesystems'),
        ];
        return $config;
    }
}
