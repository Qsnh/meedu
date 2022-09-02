<?php

/*
 * This file is part of the Qsnh/meedu.
 *
 * (c) 杭州白书科技有限公司
 */

namespace App\Http\Controllers\Backend\Api\V1;

use App\Meedu\Wechat;
use Illuminate\Http\Request;
use App\Models\AdministratorLog;

class MpWechatController extends BaseController
{
    public function menu()
    {
        $mp = Wechat::getInstance();
        $menu = $mp->menu->current();

        AdministratorLog::storeLog(
            AdministratorLog::MODULE_MP_MENU,
            AdministratorLog::OPT_VIEW,
            []
        );

        return $this->successData([
            'menu' => $menu,
        ]);
    }

    public function menuUpdate(Request $request)
    {
        $menu = $request->input('menu');
        if ($menu) {
            $response = Wechat::getInstance()->menu->create($menu['button']);
            $errCode = $response['errcode'] ?? 1001;
            if ($errCode !== 0) {
                return $this->error($response['errmsg']);
            }
        }

        AdministratorLog::storeLog(
            AdministratorLog::MODULE_MP_MENU,
            AdministratorLog::OPT_UPDATE,
            $menu
        );

        return $this->success();
    }

    public function menuEmpty()
    {
        Wechat::getInstance()->menu->delete();

        AdministratorLog::storeLog(
            AdministratorLog::MODULE_MP_MENU,
            AdministratorLog::OPT_DESTROY,
            []
        );

        return $this->success();
    }
}
