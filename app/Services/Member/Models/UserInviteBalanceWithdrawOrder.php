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

class UserInviteBalanceWithdrawOrder extends Model
{
    use SoftDeletes;

    const STATUS_DEFAULT = 0;
    const STATUS_SUCCESS = 1;
    const STATUS_FAILURE = 2;

    const STATUS_TEXT_MAP = [
        self::STATUS_DEFAULT => '已提交',
        self::STATUS_SUCCESS => '成功',
        self::STATUS_FAILURE => '失败',
    ];

    protected $table = 'user_ib_withdraw_orders';

    protected $fillable = [
        'user_id', 'total', 'before_balance', 'status',
        'channel', 'channel_name', 'channel_account', 'channel_address',
        'remark',
    ];

    protected $appends = [
        'status_text',
    ];

    public function getStatusTextAttribute()
    {
        return self::STATUS_TEXT_MAP[$this->status] ?? '';
    }
}
