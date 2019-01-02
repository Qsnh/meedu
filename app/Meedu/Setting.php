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

class Setting
{
    protected $file;

    public function __construct()
    {
        $this->file = config('meedu.save');
    }

    /**
     * 保存自定义配置.
     *
     * @param Request $request
     */
    public function save(Request $request)
    {
        $settings = collect($request->all())->filter(function ($item, $index) {
            return preg_match('/\*/', $index);
        })->mapWithKeys(function ($item, $index) {
            $index = str_replace('*', '.', $index);

            return [$index => $item];
        })->toArray();
        file_put_contents($this->file, json_encode($settings));
    }

    /**
     * 自定义配置同步到Laravel系统中.
     */
    public function sync()
    {
        if (file_exists($this->file)) {
            $config = json_decode(file_get_contents($this->file), true);
            foreach ($config as $key => $item) {
                config([$key => $item]);
            }
        }

        $this->specialSync();
    }

    protected function specialSync()
    {
        // 短信服务注册
        config(['sms.default.gateways' => [config('meedu.system.sms')]]);
    }
}
