<?php

/*
 * This file is part of the MeEdu.
 *
 * (c) 杭州白书科技有限公司
 */

namespace App\Http\Controllers\Backend\Api\V1;

use App\Meedu\Setting;
use Illuminate\Http\Request;
use App\Constant\ConfigConstant;
use App\Models\AdministratorLog;
use App\Events\AppConfigSavedEvent;
use App\Meedu\ServiceV2\Services\ConfigServiceInterface;

class SettingController extends BaseController
{
    public function index(ConfigServiceInterface $configService, Setting $setting)
    {
        AdministratorLog::storeLog(
            AdministratorLog::MODULE_SYSTEM_CONFIG,
            AdministratorLog::OPT_VIEW,
            []
        );

        $config = $configService->all();
        $syncWhitelistKeys = $setting->syncWhitelistKeys();

        foreach ($config as $key => $val) {
            // 可选值解析 => 主要用于 select 类型的配置
            if ($val['option_value']) {
                $config[$key]['option_value'] = json_decode($val['option_value'], true);
            }

            // 如果配置了 is_private=1 的话则返回的值进行打码
            if (1 === (int)$val['is_private'] && $config[$key]['value']) {
                $config[$key]['value'] = str_pad('', 12, '*');
            }

            if (in_array($val['key'], [
                'meedu.system.logo',
                'meedu.member.default_avatar',
                'meedu.system.player_thumb',
            ])) {
                $config[$key]['value'] = url($val['value']);
            }

            // 将AppConfig的value为空但是本地变量存在值的配置项进行同步
            if (in_array($val['key'], $syncWhitelistKeys) && trim($val['value']) === '' && config($val['key']) !== '') {
                $config[$key]['value'] = config($val['key']);
            }
        }

        $data = [];
        // 按照 group 整理数据
        foreach ($config as $item) {
            if (!isset($data[$item['group']])) {
                $data[$item['group']] = [];
            }

            $item['is_show'] === 1 && $data[$item['group']][] = $item;
        }

        return $this->successData($data);
    }

    public function saveHandler(Request $request, ConfigServiceInterface $configService, Setting $setting)
    {
        AdministratorLog::storeLog(
            AdministratorLog::MODULE_SYSTEM_CONFIG,
            AdministratorLog::OPT_UPDATE,
            []
        );

        // 前端提交的配置数据，格式：{key: value,...}
        $newConfigData = $request->input('config');
        if (!$newConfigData) {
            return $this->error(__('参数错误'));
        }

        foreach ($newConfigData as $key => $value) {
            if ($value === ConfigConstant::PRIVATE_MASK) {
                unset($newConfigData[$key]);
            }
        }

        // 未修改之前的配置
        $oldConfigData = $configService->allKeyValue();

        // 将修改的配置同步到数据库
        $setting->append($newConfigData);

        event(new AppConfigSavedEvent($newConfigData, $oldConfigData));

        return $this->success();
    }
}
