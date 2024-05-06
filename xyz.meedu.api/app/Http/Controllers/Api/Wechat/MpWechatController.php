<?php

/*
 * This file is part of the MeEdu.
 *
 * (c) 杭州白书科技有限公司
 */

namespace App\Http\Controllers\Api\Wechat;

use App\Meedu\Wechat;
use App\Meedu\Hooks\HookRun;
use App\Meedu\Hooks\Constant\PositionConstant;
use App\Http\Controllers\Api\V2\BaseController;

class MpWechatController extends BaseController
{
    public function serve()
    {
        $mp = Wechat::getInstance();
        $mp->server->push(function ($message) {
            return HookRun::mount(PositionConstant::MP_WECHAT_RECEIVER_MESSAGE, [
                'MsgType' => $message['MsgType'] ?? '',
                'ToUserName' => $message['ToUserName'] ?? '',//openid
                'FromUserName' => $message['FromUserName'] ?? '',
                'CreateTime' => $message['CreateTime'] ?? '',
                'MsgId' => $message['MsgId'] ?? '',
                'raw' => $message,
            ]);
        });

        return $mp->server->serve();
    }
}
