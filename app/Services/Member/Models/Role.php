<?php

/*
 * This file is part of the Qsnh/meedu.
 *
 * (c) XiaoTeng <616896861@qq.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace App\Services\Member\Models;

use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    const IS_SHOW_YES = 1;
    const IS_SHOW_NO = 0;

    protected $table = 'roles';

    protected $fillable = [
        'name', 'charge', 'expire_days', 'weight', 'description',
        'is_show',
    ];

    protected $appends = [
        'desc_rows',
    ];

    /**
     * @return array
     */
    public function getDescRowsAttribute()
    {
        return explode("\n", $this->description);
    }

    /**
     * @return array
     */
    public function descriptionRows()
    {
        return explode("\n", $this->getAttribute('description'));
    }

    /**
     * 作用域：显示.
     *
     * @param $query
     *
     * @return mixed
     */
    public function scopeShow($query)
    {
        return $query->where('is_show', self::IS_SHOW_YES);
    }

    /**
     * @return string
     */
    public function statusText()
    {
        return $this->is_show == self::IS_SHOW_YES ? '显示' : '不显示';
    }
}
