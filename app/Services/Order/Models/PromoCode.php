<?php

/*
 * This file is part of the Qsnh/meedu.
 *
 * (c) XiaoTeng <616896861@qq.com>
 */

namespace App\Services\Order\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PromoCode extends Model
{
    use SoftDeletes;

    protected $table = 'promo_codes';

    protected $fillable = [
        'user_id', 'code', 'expired_at',
        'invite_user_reward', 'invited_user_reward',
        // 可使用次数,0为不限制
        'use_times',
        // 被使用次数
        'used_times',
    ];
}
