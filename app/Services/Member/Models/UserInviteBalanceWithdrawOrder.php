<?php

/*
 * This file is part of the Qsnh/meedu.
 *
 * (c) 杭州白书科技有限公司
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
        return $this->statusMapText()[$this->status] ?? '';
    }

    public function statusMapText()
    {
        return [
            self::STATUS_DEFAULT => __('已提交'),
            self::STATUS_SUCCESS => __('成功'),
            self::STATUS_FAILURE => __('失败'),
        ];
    }
}
