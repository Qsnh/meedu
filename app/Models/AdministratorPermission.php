<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AdministratorPermission extends Model
{

    protected $table = 'administrator_permissions';

    protected $fillable = [
        'display_name', 'slug', 'description',
        'method', 'url',
    ];

    protected $appends = [
        'edit_url', 'destroy_url',
    ];

    /**
     * 权限下的角色
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function roles()
    {
        return $this->belongsToMany(
            AdministratorRole::class,
            'administrator_role_permission_relation',
            'permission_id',
            'role_id'
        );
    }

    public function getEditUrlAttribute()
    {
        return route('backend.administrator_permission.edit', $this);
    }

    public function getDestroyUrlAttribute()
    {
        return route('backend.administrator_permission.destroy', $this);
    }

    /**
     * @return array
     */
    public function getMethodArray()
    {
        $method = $this->getOriginal('method');
        return $method ? explode('|', $method) : [];
    }

}
