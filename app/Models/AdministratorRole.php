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

use Illuminate\Database\Eloquent\Model;

class AdministratorRole extends Model
{
    protected $table = 'administrator_roles';

    protected $fillable = [
        'display_name', 'slug', 'description',
    ];

    protected $appends = [
        'permission_ids',
    ];

    public function getPermissionIdsAttribute()
    {
        return $this->permissions()->select(['id'])->get()->pluck('id')->toArray();
    }

    /**
     * 角色下的管理员.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function administrators()
    {
        return $this->belongsToMany(
            Administrator::class,
            'administrator_role_relation',
            'role_id',
            'administrator_id'
        );
    }

    /**
     * 角色下的权限.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function permissions()
    {
        return $this->belongsToMany(
            AdministratorPermission::class,
            'administrator_role_permission_relation',
            'role_id',
            'permission_id'
        );
    }

    /**
     * @param AdministratorPermission $permission
     *
     * @return bool
     */
    public function hasPermission(AdministratorPermission $permission)
    {
        return $this->permissions()->where('id', $permission->id)->exists();
    }

    /**
     * 当前角色是否属于某个用户.
     *
     * @param Administrator $administrator
     *
     * @return mixed
     */
    public function hasAdministrator(Administrator $administrator)
    {
        return $this->administrators()->whereId($administrator->id)->exists();
    }
}
