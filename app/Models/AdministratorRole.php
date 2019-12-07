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

/**
 * App\Models\AdministratorRole.
 *
 * @property int                                                                            $id
 * @property string                                                                         $display_name   角色名
 * @property string                                                                         $slug           slug
 * @property string                                                                         $description    角色描述
 * @property \Illuminate\Support\Carbon|null                                                $created_at
 * @property \Illuminate\Support\Carbon|null                                                $updated_at
 * @property \Illuminate\Database\Eloquent\Collection|\App\Models\Administrator[]           $administrators
 * @property string                                                                         $destroy_url
 * @property string                                                                         $edit_url
 * @property string                                                                         $permission_url
 * @property \Illuminate\Database\Eloquent\Collection|\App\Models\AdministratorPermission[] $permissions
 *
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\AdministratorRole newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\AdministratorRole newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\AdministratorRole query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\AdministratorRole whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\AdministratorRole whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\AdministratorRole whereDisplayName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\AdministratorRole whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\AdministratorRole whereSlug($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\AdministratorRole whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class AdministratorRole extends Model
{
    protected $table = 'administrator_roles';

    protected $fillable = [
        'display_name', 'slug', 'description',
    ];

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
