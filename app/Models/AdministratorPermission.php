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
 * App\Models\AdministratorPermission.
 *
 * @property int                                                                      $id
 * @property string                                                                   $display_name 权限名
 * @property string                                                                   $slug         slug
 * @property string                                                                   $description  描述
 * @property string                                                                   $method       HTTP动作
 * @property string                                                                   $url          URL
 * @property \Illuminate\Support\Carbon|null                                          $created_at
 * @property \Illuminate\Support\Carbon|null                                          $updated_at
 * @property mixed                                                                    $destroy_url
 * @property mixed                                                                    $edit_url
 * @property \Illuminate\Database\Eloquent\Collection|\App\Models\AdministratorRole[] $roles
 *
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\AdministratorPermission newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\AdministratorPermission newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\AdministratorPermission query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\AdministratorPermission whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\AdministratorPermission whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\AdministratorPermission whereDisplayName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\AdministratorPermission whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\AdministratorPermission whereMethod($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\AdministratorPermission whereSlug($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\AdministratorPermission whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\AdministratorPermission whereUrl($value)
 * @mixin \Eloquent
 */
class AdministratorPermission extends Model
{
    protected $table = 'administrator_permissions';

    protected $fillable = [
        'display_name', 'slug', 'description',
        'method', 'url',
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
            'administrator_role_permission_relation',
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
