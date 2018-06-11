<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AdministratorRole extends Model
{

    protected $table = 'administrator_roles';

    protected $fillable = [
        'display_name', 'slug', 'description',
    ];

    /**
     * 角色下的管理员
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
     * 角色下的权限
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

}
