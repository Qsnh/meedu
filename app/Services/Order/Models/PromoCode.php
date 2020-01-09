<?php

/*
 * This file is part of the Qsnh/meedu.
 *
 * (c) XiaoTeng <616896861@qq.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
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
        'use_times', 'used_times',
    ];
}
