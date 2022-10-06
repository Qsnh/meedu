<?php

/*
 * This file is part of the Qsnh/meedu.
 *
 * (c) 杭州白书科技有限公司
 */

namespace App\Meedu\ServiceV2\Models;

use PHPOpenSourceSaver\JWTAuth\Contracts\JWTSubject;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable implements JWTSubject
{
    use Notifiable, HasFactory;

    protected $fillable = [
        'avatar', 'nick_name', 'password', 'mobile',
        'is_lock', 'is_active', 'role_id', 'role_expired_at',
        'invite_user_id', 'invite_balance', 'invite_user_expired_at',
        'is_password_set', 'is_set_nickname',
        'register_ip', 'register_area', 'last_login_id',
    ];

    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    public function getJWTCustomClaims()
    {
        return [];
    }

    protected $hidden = [
        'password', 'remember_token',
    ];
}
