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

class FaqArticle extends Model
{
    protected $table = 'faq_articles';

    protected $fillable = [
        'category_id', 'admin_id', 'title', 'content',
    ];

    protected $appends = [
        'edit_url', 'destroy_url',
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function category()
    {
        return $this->belongsTo(FaqCategory::class, 'category_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function admin()
    {
        return $this->belongsTo(Administrator::class, 'admin_id');
    }

    /**
     * @return string
     */
    public function getEditUrlAttribute()
    {
        return route('backend.faq.article.edit', $this);
    }

    /**
     * @return string
     */
    public function getDestroyUrlAttribute()
    {
        return route('backend.faq.article.destroy', $this);
    }

    /**
     * @return string
     */
    public function getContent()
    {
        return markdown_to_html($this->content);
    }
}
