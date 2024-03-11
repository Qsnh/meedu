<?php

/*
 * This file is part of the MeEdu.
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
        'display_name', 'slug', 'description', 'url', 'group_name',

        // HTTP请求方法[GET,POST,PUT,DELETE] 还有额外的 [DATA] => 意味着数据权限
        'method',

        // 废弃字段
        'route',
    ];

    public function roles()
    {
        return $this->belongsToMany(
            AdministratorRole::class,
            TableConstant::TABLE_ROLE_PERMISSION_RELATION,
            'permission_id',
            'role_id'
        );
    }

    public function getMethodArray(): array
    {
        $method = $this->getOriginal('method');

        return $method ? explode('|', $method) : [];
    }
}
