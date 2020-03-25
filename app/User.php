<?php

/*
 * This file is part of the Qsnh/meedu.
 *
 * (c) XiaoTeng <616896861@qq.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace App;

use Carbon\Carbon;
use App\Models\Role;
use App\Models\Order;
use App\Models\Socialite;
use App\Models\VideoComment;
use App\Models\CourseComment;
use App\Models\UserJoinRoleRecord;
use App\Models\traits\CreatedAtBetween;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;
    use CreatedAtBetween;

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
        'avatar', 'nick_name', 'mobile', 'password',
        'is_lock', 'is_active', 'role_id', 'role_expired_at',
        'invite_user_id', 'invite_balance', 'invite_user_expired_at',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

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
     * 用户的课程评论.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function courseComments()
    {
        return $this->hasMany(CourseComment::class, 'user_id');
    }

    /**
     * 用户的视频评论.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function videoComments()
    {
        return $this->hasMany(VideoComment::class, 'user_id');
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
     * 关联订单.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function orders()
    {
        return $this->hasMany(Order::class, 'user_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function joinRoles()
    {
        return $this->hasMany(UserJoinRoleRecord::class, 'user_id');
    }

    /**
     * 今日注册用户数量.
     *
     * @return mixed
     */
    public static function todayRegisterCount()
    {
        return self::createdAtBetween(
            Carbon::now()->format('Y-m-d'),
            Carbon::now()->addDays(1)->format('Y-m-d')
        )->count();
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function socialite()
    {
        return $this->hasMany(Socialite::class, 'user_id');
    }
}
