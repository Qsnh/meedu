<?php

/*
 * This file is part of the Qsnh/meedu.
 *
 * (c) XiaoTeng <616896861@qq.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace App\Services\Member\Models;

use Laravel\Passport\HasApiTokens;
use Tymon\JWTAuth\Contracts\JWTSubject;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable implements JWTSubject
{
    use Notifiable;
    use HasApiTokens;

    const ACTIVE_YES = 1;
    const ACTIVE_NO = -1;

    const LOCK_YES = 1;
    const LOCK_NO = -1;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'avatar', 'nick_name', 'c', 'password', 'mobile',
        'is_lock', 'is_active', 'role_id', 'role_expired_at',
    ];

    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    public function getJWTCustomClaims()
    {
        return [];
    }

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * 重载passport方法.
     *
     * @param $name
     *
     * @return mixed
     */
    public function findForPassport($name)
    {
        return self::whereMobile($name)->first();
    }

    /**
     * 所属角色.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function role()
    {
        return $this->belongsTo(Role::class, 'role_id');
    }

    /**
     * 头像修饰器.
     *
     * @return \Illuminate\Config\Repository|mixed
     */
    public function getAvatarAttribute($avatar)
    {
        return $avatar ?: url(config('meedu.member.default_avatar'));
    }

    /**
     * 余额扣除.
     *
     * @param $money
     */
    public function credit1Dec($money)
    {
        $this->credit1 -= $money;
        $this->save();
    }

    /**
     * 是否为有效会员.
     *
     * @return bool
     */
    public function activeRole()
    {
        return $this->role_id && time() < strtotime($this->role_expired_at);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function joinRoles()
    {
        return $this->hasMany(UserJoinRoleRecord::class, 'user_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function socialite()
    {
        return $this->hasMany(Socialite::class, 'user_id');
    }

    /**
     * 判断是否绑定手机.
     *
     * @return bool
     */
    public function isBindMobile()
    {
        return substr($this->mobile, 0, 1) == 1;
    }
}
