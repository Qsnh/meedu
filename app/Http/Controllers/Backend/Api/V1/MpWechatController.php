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

use App\Meedu\Wechat;
use Illuminate\Http\Request;

class MpWechatController extends BaseController
{
    public function menu()
    {
        $mp = Wechat::getInstance();
        $menu = $mp->menu->current();

        return $this->successData([
            'menu' => $menu,
        ]);
    }

    public function menuUpdate(Request $request)
    {
        $menu = $request->input('menu');
        if ($menu) {
            $response = Wechat::getInstance()->menu->create($menu['button']);
            $errcode = $response['errcode'] ?? 1001;
            if ($errcode !== 0) {
                return $this->error($response['errmsg']);
            }
        }

        return $this->success();
    }

    public function menuEmpty()
    {
        Wechat::getInstance()->menu->delete();
        return $this->success();
    }
}
