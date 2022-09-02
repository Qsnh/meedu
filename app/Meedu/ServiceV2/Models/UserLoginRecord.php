<?php

/*
 * This file is part of the Qsnh/meedu.
 *
 * (c) 杭州白书科技有限公司
 */

namespace App\Meedu\ServiceV2\Models;

use App\Constant\TableConstant;
use Illuminate\Database\Eloquent\Model;

class UserLoginRecord extends Model
{
    protected $table = TableConstant::TABLE_USER_LOGIN_RECORDS;

    protected $fillable = [
        'user_id', 'ip', 'platform',
        'ua', 'token', 'iss', 'jti', 'exp', 'is_logout',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
