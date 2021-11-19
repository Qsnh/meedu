<?php

/*
 * This file is part of the Qsnh/meedu.
 *
 * (c) 杭州白书科技有限公司
 */

namespace App\Services\Member\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class UserInviteBalanceRecord extends Model
{
    use SoftDeletes, HasFactory;

    const TYPE_DEFAULT = 0;
    const TYPE_ORDER_DRAW = 1;
    const TYPE_ORDER_WITHDRAW = 2;
    const TYPE_ORDER_WITHDRAW_BACK = 3;

    protected $table = 'user_invite_balance_records';

    protected $fillable = [
        'user_id', 'type', 'total', 'desc',
    ];
}
