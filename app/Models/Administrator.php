<?php

/*
 * This file is part of the Qsnh/meedu.
 *
 * (c) XiaoTeng <616896861@qq.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace App\Models;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Tymon\JWTAuth\Contracts\JWTSubject;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

/**
 * App\Models\Administrator.
 *
 * @property int                                                                                                       $id
 * @property string                                                                                                    $name            姓名
 * @property string                                                                                                    $email           邮箱
 * @property string                                                                                                    $password        密码
 * @property string                                                                                                    $last_login_ip   最后登录IP
 * @property string|null                                                                                               $last_login_date 最后登录时间
 * @property string|null                                                                                               $remember_token
 * @property \Illuminate\Support\Carbon|null                                                                           $created_at
 * @property \Illuminate\Support\Carbon|null                                                                           $updated_at
 * @property mixed                                                                                                     $destroy_url
 * @property mixed                                                                                                     $edit_url
 * @property \Illuminate\Notifications\DatabaseNotificationCollection|\Illuminate\Notifications\DatabaseNotification[] $notifications
 * @property \Illuminate\Database\Eloquent\Collection|\App\Models\AdministratorRole[]                                  $roles
 *
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Administrator newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Administrator newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Administrator query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Administrator whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Administrator whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Administrator whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Administrator whereLastLoginDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Administrator whereLastLoginIp($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Administrator whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Administrator wherePassword($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Administrator whereRememberToken($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Administrator whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Administrator extends Authenticatable implements JWTSubject
{
    use Notifiable;

    protected $table = 'administrators';

    protected $fillable = [
        'name', 'email', 'password', 'last_login_ip',
        'last_login_date',
    ];

    protected $hidden = [
        'password', 'remember_token',
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
     * 从Request上创建管理员用户.
     *
     * @param Request $request
     *
     * @return Administrator
     */
    public static function createFromRequest(Request $request)
    {
        $data = [
            'name' => $request->input('name'),
            'email' => $request->input('email'),
            'password' => Hash::make($request->input('password')),
            'last_login_ip' => '',
            'last_login_date' => '',
        ];
        $self = new self($data);
        $self->save();

        return $self;
    }

    /**
     * 管理员包含的角色.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function roles()
    {
        return $this->belongsToMany(
            AdministratorRole::class,
            'administrator_role_relation',
            'administrator_id',
            'role_id'
        );
    }

    /**
     * 当前管理员是否可以删除.
     *
     * @return bool
     */
    public function couldDestroy()
    {
        return $this->roles()->where('slug', config('meedu.administrator.super_slug'))->exists();
    }

    /**
     * 是否存在指定角色.
     *
     * @param AdministratorRole $role
     *
     * @return bool
     */
    public function hasRole(AdministratorRole $role)
    {
        return $this->roles()->where('id', $role->id)->exists();
    }

    /**
     * 获取当前管理员用户下的所有权限ID.
     *
     * @return array|\Illuminate\Support\Collection
     */
    public function permissionIds()
    {
        $roles = $this->roles;
        if (!$roles) {
            return [];
        }
        $permissionIds = collect([]);
        foreach ($roles as $role) {
            $permissionIds = $permissionIds->merge($role->permissions()->select('id')->pluck('id'));
        }

        return $permissionIds->unique();
    }

    /**
     * 是否为超级管理员.
     *
     * @return bool
     */
    public function isSuper()
    {
        return $this->roles()->whereSlug(config('meedu.administrator.super_slug'))->exists();
    }

    /**
     * 当前管理员是否可以访问某个请求
     *
     * @param Request $request
     *
     * @return bool
     */
    public function couldVisited(Request $request)
    {
        $path = $request->getPathInfo();
        $method = $request->getMethod();

        // 查找到对应的权限
        $permissions = AdministratorPermission::where('method', 'like', "%{$method}%")->get();
        $existsPermission = null;
        foreach ($permissions as $permission) {
            if (preg_match("#{$permission->url}$#", $path)) {
                $existsPermission = $permission;
                break;
            }
        }
        if (!$existsPermission) {
            return false;
        }

        return in_array($existsPermission->id, $this->permissionIds()->toArray());
    }
}
