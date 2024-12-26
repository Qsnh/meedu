<?php

/*
 * This file is part of the MeEdu.
 *
 * (c) 杭州白书科技有限公司
 */

namespace App\Meedu\ServiceV2\Models;

use App\Constant\TableConstant;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class PromoCode extends Model
{

    use SoftDeletes, HasFactory;

    protected $table = TableConstant::TABLE_PROMO_CODES;

    protected $fillable = [
        'user_id', 'code', 'expired_at',
        'invite_user_reward', 'invited_user_reward',
        // 可使用次数,0为不限制
        'use_times',
        // 被使用次数
        'used_times',
    ];

}
