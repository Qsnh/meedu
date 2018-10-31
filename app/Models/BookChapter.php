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
use Illuminate\Database\Eloquent\SoftDeletes;

class BookChapter extends Model
{
    use SoftDeletes;

    const SHOW_YES = 1;
    const SHOW_NO = -1;

    protected $table = 'book_chapters';

    protected $fillable = [
        'book_id', 'user_id', 'title',
        'content', 'view_num', 'published_at',
        'is_show',
    ];

    protected $appends = [
        'edit_url', 'destroy_url',
    ];

    /**
     * @return string
     */
    public function getEditUrlAttribute()
    {
        return route('backend.book.chapter.edit', [$this->book_id, $this->id]);
    }

    /**
     * @return string
     */
    public function getDestroyUrlAttribute()
    {
        return route('backend.book.chapter.destroy', [$this->book_id, $this->id]);
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
        return $query->where('is_show', self::SHOW_YES);
    }

    /**
     * 作用域：不显示.
     *
     * @param $query
     *
     * @return mixed
     */
    public function scopeNotShow($query)
    {
        return $query->where('is_show', self::SHOW_NO);
    }

    /**
     * 作用域：上线的视频.
     *
     * @param $query
     *
     * @return mixed
     */
    public function scopePublished($query)
    {
        return $query->where('published_at', '<=', date('Y-m-d H:i:s'));
    }

    /**
     * @param $query
     *
     * @return mixed
     */
    public function scopePublishedDesc($query)
    {
        return $query->orderByDesc('published_at');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function book()
    {
        return $this->belongsTo(Book::class, 'book_id');
    }

    /**
     * @return string
     */
    public function getContent()
    {
        return markdown_to_html($this->content);
    }
}
