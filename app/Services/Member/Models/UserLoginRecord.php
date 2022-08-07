<?php

/*
 * This file is part of the Qsnh/meedu.
 *
 * (c) 杭州白书科技有限公司
 */

namespace App\Services\Member\Models;

use App\Constant\TableConstant;
use Illuminate\Database\Eloquent\Model;

class UserLoginRecord extends Model
{
    protected $table = TableConstant::TABLE_USER_LOGIN_RECORDS;

    protected $fillable = [
        'user_id', 'ip', 'area', 'at', 'platform',
    ];
}
