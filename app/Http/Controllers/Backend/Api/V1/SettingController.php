<?php

/*
 * This file is part of the Qsnh/meedu.
 *
 * (c) XiaoTeng <616896861@qq.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace App\Http\Controllers\Backend\Api\V1;

use App\Meedu\Setting;
use Illuminate\Http\Request;
use App\Events\AppConfigSavedEvent;

class SettingController extends BaseController
{
    public function index(Setting $setting)
    {
        $config = $setting->getCanEditConfig();
        foreach ($config as $key => $val) {
            // 可选值
            if ($val['option_value']) {
                $config[$key]['option_value'] = json_decode($val['option_value'], true);
            }
            // 私密信息
            if ((int)$val['is_private'] === 1 && $config[$key]['value']) {
                $config[$key]['value'] = str_pad('', 12, '*');
            }
        }
        $data = [];
        foreach ($config as $item) {
            if (!isset($data[$item['group']])) {
                $data[$item['group']] = [];
            }
            $item['is_show'] === 1 && $data[$item['group']][] = $item;
        }

        return $this->successData($data);
    }

    public function saveHandler(Request $request, Setting $setting)
    {
        $data = $request->input('config');
        $setting->append($data);

        event(new AppConfigSavedEvent());

        return $this->success();
    }
}
