<?php

/*
 * This file is part of the MeEdu.
 *
 * (c) 杭州白书科技有限公司
 */

namespace App\Services\Member\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Role extends Model
{
    use HasFactory;

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
