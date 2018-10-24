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

class AdministratorMenu extends Model
{
    protected $table = 'administrator_menus';

    protected $fillable = [
        'parent_id', 'name', 'url', 'order', 'permission_id',
    ];

    protected $appends = [
        'edit_url', 'destroy_url',
    ];

    public function getEditUrlAttribute()
    {
        return route('backend.administrator_menu.edit', $this);
    }

    public function getDestroyUrlAttribute()
    {
        return route('backend.administrator_menu.destroy', $this);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function permission()
    {
        return $this->belongsTo(AdministratorPermission::class, 'permission_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function children()
    {
        return $this->hasMany(self::class, 'parent_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function parent()
    {
        return $this->belongsTo(self::class, 'parent_id');
    }

    /**
     * 获取菜单层级列表.
     *
     * @return mixed
     */
    public function menus()
    {
        $parentMenus = self::with('children')->whereParentId(0)->orderBy('order')->get();

        return $parentMenus;
    }

    /**
     * 作用域：根目录.
     *
     * @param $query
     *
     * @return mixed
     */
    public function scopeRootLevel($query)
    {
        return $query->whereParentId(0);
    }

    /**
     * 作用域：非超级管理员专属的菜单.
     *
     * @param $query
     *
     * @return mixed
     */
    public function scopeNotSuper($query)
    {
        return $query->where('permission_id', '<>', -1);
    }

    /**
     * 作用域：升序[order].
     *
     * @param $query
     *
     * @return mixed
     */
    public function scopeOrderAsc($query)
    {
        return $query->orderBy('order');
    }
}
