<?php

/*
 * This file is part of the Qsnh/meedu.
 *
 * (c) 杭州白书科技有限公司
 */

namespace App\Services\Member\Models;

use App\Constant\TableConstant;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class UserJoinRoleRecord extends Model
{
    use HasFactory;

    protected $table = TableConstant::TABLE_USER_JOIN_ROLE_RECORDS;

    protected $fillable = [
        'user_id', 'role_id', 'charge', 'started_at', 'expired_at',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function role()
    {
        return $this->belongsTo(Role::class, 'role_id');
    }
}
