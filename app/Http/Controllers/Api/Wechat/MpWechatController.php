<?php

/*
 * This file is part of the Qsnh/meedu.
 *
 * (c) XiaoTeng <616896861@qq.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace App\Http\Controllers\Api\Wechat;

use App\Meedu\Wechat;
use App\Meedu\Hooks\HookRun;
use App\Meedu\Hooks\HookParams;
use App\Meedu\Hooks\Constant\PositionConstant;
use App\Http\Controllers\Api\V2\BaseController;

class MpWechatController extends BaseController
{
    public function serve()
    {
        $mp = Wechat::getInstance();
        $mp->server->push(function ($message) {
            return HookRun::run(PositionConstant::MP_WECHAT_RECEIVER_MESSAGE, new HookParams([
                'MsgType' => $message['MsgType'] ?? '',
                'ToUserName' => $message['ToUserName'] ?? '',
                'FromUserName' => $message['FromUserName'] ?? '',
                'CreateTime' => $message['CreateTime'] ?? '',
                'MsgId' => $message['MsgId'] ?? '',
                'raw' => $message,
            ]));
        });

        return $mp->server->serve();
    }
}
