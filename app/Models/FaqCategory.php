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

class FaqCategory extends Model
{
    protected $table = 'faq_categories';

    protected $fillable = [
        'name', 'sort',
    ];

    protected $appends = [
        'edit_url', 'destroy_url',
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function articles()
    {
        return $this->hasMany(FaqArticle::class, 'category_id');
    }

    /**
     * 作用域：排序.
     *
     * @param $query
     *
     * @return mixed
     */
    public function scopeSortAsc($query)
    {
        return $query->orderBy('sort');
    }

    /**
     * @return string
     */
    public function getEditUrlAttribute()
    {
        return route('backend.faq.category.edit', $this);
    }

    /**
     * @return string
     */
    public function getDestroyUrlAttribute()
    {
        return route('backend.faq.category.destroy', $this);
    }
}
