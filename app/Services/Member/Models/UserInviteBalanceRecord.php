<?php

/*
 * This file is part of the Qsnh/meedu.
 *
 * (c) XiaoTeng <616896861@qq.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace App\Services\Member\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class UserInviteBalanceRecord extends Model
{
    use SoftDeletes;

    const TYPE_DEFAULT = 0;
    const TYPE_ORDER_DRAW = 1;
    const TYPE_ORDER_WITHDRAW = 2;
    const TYPE_ORDER_WITHDRAW_BACK = 3;

    const TYPE_TEXT = [
        self::TYPE_DEFAULT => '邀请奖励',
        self::TYPE_ORDER_DRAW => '订单抽成',
        self::TYPE_ORDER_WITHDRAW => '提现',
        self::TYPE_ORDER_WITHDRAW_BACK => '提现退回',
    ];

    protected $table = 'user_invite_balance_records';

    protected $fillable = [
        'user_id', 'type', 'total', 'desc',
    ];
}
