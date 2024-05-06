<?php

/*
 * This file is part of the MeEdu.
 *
 * (c) 杭州白书科技有限公司
 */

namespace App\Models;

use App\Constant\TableConstant;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class AdministratorRole extends Model
{
    use HasFactory;

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
            TableConstant::TABLE_ADMIN_ROLE_RELATION,
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
            TableConstant::TABLE_ROLE_PERMISSION_RELATION,
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
