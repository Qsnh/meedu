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
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Administrator extends Authenticatable
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

    protected $appends = [
        'edit_url', 'destroy_url',
    ];

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
            'password' => bcrypt($request->input('password')),
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

    public function getEditUrlAttribute()
    {
        return route('backend.administrator.edit', $this);
    }

    public function getDestroyUrlAttribute()
    {
        return route('backend.administrator.destroy', $this);
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
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function announcements()
    {
        return $this->hasMany(Announcement::class, 'admin_id');
    }

    /**
     * 获取当前管理员用户下的所有权限ID.
     *
     * @return array|\Illuminate\Support\Collection
     */
    public function permissionIds()
    {
        $roles = $this->roles;
        if (! $roles) {
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
        if (! $existsPermission) {
            return false;
        }

        return in_array($existsPermission->id, $this->permissionIds()->toArray());
    }
}
