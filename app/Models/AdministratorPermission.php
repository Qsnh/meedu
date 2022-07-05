<?php

/*
 * This file is part of the Qsnh/meedu.
 *
 * (c) 杭州白书科技有限公司
 */

namespace App\Models;

use App\Constant\TableConstant;
use Illuminate\Database\Eloquent\Model;

class AdministratorPermission extends Model
{
    protected $table = 'administrator_permissions';

    protected $fillable = [
        'display_name', 'slug', 'description',
        'method', 'url', 'route', 'group_name',
    ];

    /**
     * 权限下的角色.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function roles()
    {
        return $this->belongsToMany(
            AdministratorRole::class,
            TableConstant::TABLE_ROLE_PERMISSION_RELATION,
            'permission_id',
            'role_id'
        );
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
