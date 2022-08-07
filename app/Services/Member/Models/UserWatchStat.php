<?php

/*
 * This file is part of the Qsnh/meedu.
 *
 * (c) 杭州白书科技有限公司
 */

namespace App\Services\Member\Models;

use App\Constant\TableConstant;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class UserWatchStat extends Model
{
    use SoftDeletes;

    protected $table = TableConstant::TABLE_USER_WATCH_STAT;

    protected $fillable = [
        'user_id', 'year', 'month', 'day', 'seconds',
    ];
}
